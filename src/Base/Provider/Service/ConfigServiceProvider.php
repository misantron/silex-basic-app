<?php

namespace App\Base\Provider\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /** @var \SplFileInfo */
    private $fileName;
    /** @var array */
    private $replacements = [];

    public function __construct($fileName, array $replacements = [])
    {
        $this->fileName = new \SplFileInfo($fileName);

        if (!empty($replacements)) {
            foreach ($replacements as $key => $value) {
                $this->replacements['%' . $key . '%'] = $value;
            }
        }
    }

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $config = $this->loadConfig();
        foreach ($config as $name => $value) {
            if (substr($name, 0, 1) === '%') {
                $this->replacements[$name] = (string)$value;
            }
        }
        $this->merge($app, $config);
    }

    private function merge(Container $app, array $config)
    {
        foreach ($config as $name => $value) {
            if (isset($app[$name]) && is_array($value)) {
                $app[$name] = $this->mergeRecursively($app[$name], $value);
            } else {
                $app[$name] = $this->doReplacements($value);
            }
        }
    }

    private function mergeRecursively(array $currentValue, array $newValue)
    {
        foreach ($newValue as $name => $value) {
            if (is_array($value) && isset($currentValue[$name])) {
                $currentValue[$name] = $this->mergeRecursively($currentValue[$name], $value);
            } else {
                $currentValue[$name] = $this->doReplacements($value);
            }
        }
        return $currentValue;
    }

    private function doReplacements($value)
    {
        if (empty($this->replacements)) {
            return $value;
        }
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->doReplacements($v);
            }
            return $value;
        }
        if (is_string($value)) {
            return strtr($value, $this->replacements);
        }
        return $value;
    }

    private function loadConfig()
    {
        if (!$this->fileName->isFile()) {
            throw new \RuntimeException('Config file does not exists.');
        }

        if ($this->fileName->getExtension() !== 'php') {
            throw new \RuntimeException('Invalid config file extension.');
        }

        return require_once $this->fileName->getRealPath();
    }
}