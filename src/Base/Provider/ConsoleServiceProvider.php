<?php

namespace App\Base\Provider;

use App\Base\Console\ConsoleApplication;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Command;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['console'] = function ($app) {

            $name = isset($app['console.name']) ? $app['console.name'] : 'Application console';
            $version = isset($app['console.version']) ? $app['console.version'] : '1.0.0';

            /** @var Application $app */
            $application = new ConsoleApplication($app, $name, $version);
            $application->setCatchExceptions(true);
            $application->setHelperSet(new HelperSet([
                'question' => new QuestionHelper(),
            ]));

            $configuration = new Configuration($app['db']);
            $configuration->setMigrationsNamespace($app['config']['db.migrations']['namespace']);
            if ($app['config']['db.migrations']['path']) {
                $configuration->setMigrationsDirectory($app['config']['db.migrations']['path']);
                $configuration->registerMigrationsFromDirectory($app['config']['db.migrations']['path']);
            }
            if ($app['config']['db.migrations']['name']) {
                $configuration->setName($app['config']['db.migrations']['name']);
            }
            if ($app['config']['db.migrations']['table_name']) {
                $configuration->setMigrationsTableName($app['config']['db.migrations']['table_name']);
            }

            // doctrine migrations commands
            $commands = [
                new Command\ExecuteCommand(),
                new Command\GenerateCommand(),
                new Command\MigrateCommand(),
                new Command\StatusCommand(),
                new Command\VersionCommand(),
            ];
            foreach ($commands as $command) {
                $command->setMigrationConfiguration($configuration);
                $application->add($command);
            }

            // put your custom commands into array
            $application->addCommands([

            ]);

            return $application;
        };
    }
}