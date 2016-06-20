<?php

namespace App\Base\Console;

use Symfony\Component\Console\Command\Command;

/**
 * Class BaseCommand
 * @package App\Base\Console
 * 
 * @method ConsoleApplication getApplication()
 */
class BaseCommand extends Command
{
    /**
     * @return \Silex\Application
     */
    public function getBaseApplication()
    {
        return $this->getApplication()->getSilexApplication();
    }
}