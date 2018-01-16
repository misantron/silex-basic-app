<?php

namespace Application\Base\Provider;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Command;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * Class ConsoleServiceProvider
 * @package Application\Base\Provider
 */
class ConsoleServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['console'] = function ($app) {

            $name = $app['console.name'] ?? 'Application console';
            $version = $app['console.version'] ?? '1.0.0';

            $console = new Application($name, $version);
            $console->setCatchExceptions(true);
            $console->setHelperSet(new HelperSet([
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
                $console->add($command);
            }

            return $console;
        };
    }
}