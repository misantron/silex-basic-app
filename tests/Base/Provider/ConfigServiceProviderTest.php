<?php

namespace App\Tests\Base\Provider;

use App\Base\Provider\ConfigServiceProvider;
use App\Tests\BaseTestCase;
use Silex\Application;

class ConfigServiceProviderTest extends BaseTestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testInitWithoutConfig()
    {
        $this->app->register(new ConfigServiceProvider(''));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidConfigPath()
    {
        $this->app->register(new ConfigServiceProvider(__DIR__ . '/../../resources/config_not_exists.php'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInvalidConfigFormat()
    {
        $this->app->register(new ConfigServiceProvider(__DIR__ . '/../../resources/config.json'));
    }

    public function testConfigLoad()
    {
        $provider = new ConfigServiceProvider(__DIR__ . '/../../resources/config_without_replacements.php');

        $fileName = $this->getPropertyValue($provider, 'fileName');
        $this->assertInstanceOf(\SplFileInfo::class, $fileName);

        $replacements = $this->getPropertyValue($provider, 'replacements');
        $this->assertInternalType('array', $replacements);
        $this->assertEmpty($replacements);

        $this->app->register($provider);

        $this->assertArrayHasKey('debug', $this->app);
        $this->assertTrue($this->app['debug']);

        $this->assertArrayHasKey('date.timezone', $this->app);
        $this->assertEquals('Europe/London', $this->app['date.timezone']);
    }

    public function testConfigWithReplacements()
    {
        $provider = new ConfigServiceProvider(__DIR__ . '/../../resources/config.php', [
            'root_path' => __DIR__,
            'lifetime' => 5400,
        ]);

        $this->app->register($provider);

        $this->assertEquals(__DIR__ . '/cache', $this->app['cache']['local']['path']);
        $this->assertEquals(5400, $this->app['cache']['local']['lifetime']);
    }

    public function testConfigMerge()
    {
        $this->app['cache'] = [
            'memcache' => [
                'server' => [
                    'host' => '192.168.0.10',
                    'port' => 11213
                ]
            ]
        ];

        $provider = new ConfigServiceProvider(__DIR__ . '/../../resources/config_to_merge.php', [
            'root_path' => __DIR__,
            'lifetime' => 5400,
        ]);

        $this->app->register($provider);

        $this->assertEquals('127.0.0.1', $this->app['cache']['memcache']['host']);
        $this->assertEquals(11211, $this->app['cache']['memcache']['port']);
    }
}