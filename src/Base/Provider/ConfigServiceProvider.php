<?php

namespace App\Base\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $replacements = [];

    /**
     * @param array $filePaths
     * @param array $replacements
     * @throws \RuntimeException
     */
    public function __construct(array $filePaths, array $replacements = [])
    {
        $files = array_filter($filePaths, function ($file) {
            return file_exists($file);
        });
        $merged = array_reduce($files, function ($carry, $path) {
            $file = new \SplFileInfo($path);
            if ($file->isFile() && $file->getExtension() === 'php') {
                $config = require $file->getRealPath();
                $carry = array_merge_recursive($carry, $config);
            }
            return $carry;
        }, []);

        if (empty($merged)) {
            throw new \RuntimeException('Application config is empty');
        }

        $this->config = $merged;

        foreach ($replacements as $key => $value) {
            $this->replacements['%' . $key . '%'] = $value;
        }
    }

    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        foreach ($this->config as $name => $value) {
            if (substr($name, 0, 1) === '%') {
                $this->replacements[$name] = (string)$value;
            }
        }
        $this->merge($app);
    }

    /**
     * @param Container $app
     */
    private function merge(Container $app)
    {
        $app['config'] = new Container();
        foreach ($this->config as $name => $value) {
            if (isset($app[$name]) && is_array($value)) {
                $app['config'][$name] = $this->mergeRecursively($app[$name], $value);
            } else {
                $app['config'][$name] = $this->doReplacements($value);
            }
        }
    }

    /**
     * @param array $currentValue
     * @param array $newValue
     * @return array
     */
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

    /**
     * @param array|string $value
     * @return array|string
     */
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
}