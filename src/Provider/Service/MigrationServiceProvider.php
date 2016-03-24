<?php

namespace App\Provider\Service;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Command;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Knp\Console\ConsoleEvents;
use Knp\Console\ConsoleEvent;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\HelperSet;

class MigrationServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['db.migrations.namespace'] = 'DoctrineMigrations';
        $app['db.migrations.path'] = null;
        $app['db.migrations.table_name'] = null;
        $app['db.migrations.name'] = null;

        $app['dispatcher']->addListener(ConsoleEvents::INIT, function (ConsoleEvent $event) use ($app) {
            $application = $event->getApplication();
            $helpers = ['question' => new QuestionHelper()];
            $helperSet = new HelperSet($helpers);
            $application->setHelperSet($helperSet);
            $config = new Configuration($app['db']);
            $config->setMigrationsNamespace($app['db.migrations.namespace']);
            if ($app['db.migrations.path']) {
                $config->setMigrationsDirectory($app['db.migrations.path']);
                $config->registerMigrationsFromDirectory($app['db.migrations.path']);
            }
            if ($app['db.migrations.name']) {
                $config->setName($app['db.migrations.name']);
            }
            if ($app['db.migrations.table_name']) {
                $config->setMigrationsTableName($app['db.migrations.table_name']);
            }
            $commands = [
                new Command\DiffCommand(),
                new Command\ExecuteCommand(),
                new Command\GenerateCommand(),
                new Command\MigrateCommand(),
                new Command\StatusCommand(),
                new Command\VersionCommand(),
            ];
            foreach ($commands as $command) {
                /** @var Command\AbstractCommand $command */
                $command->setMigrationConfiguration($config);
                $application->add($command);
            }
        });
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {

    }
}