<?php

namespace App\Console\Command;

use App\Base\Console\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigBuildCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('config.build')
            ->setDescription('Build application config based on input env')
            ->addArgument('env', InputArgument::REQUIRED, 'Application env type')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $input->getArgument('env');
        $cacheDir = realpath('./') . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
        $configExampleDir = realpath('./') . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;

        if(!file_exists($configExampleDir . "app.{$env}.php")) {
            throw new \InvalidArgumentException('Example config for this env does not exists');
        }
        $content = file_get_contents($configExampleDir . "app.{$env}.php");

        $fh = fopen($cacheDir . 'config.php', 'w');
        if($fh === false) {
            throw new \RuntimeException('Unable to open cache config file');
        }
        fwrite($fh, $content);
        fclose($fh);

        $output->writeln('Application config cache was created');
    }
}