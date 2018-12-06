<?php
/**
 * FamePHP
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\api;

/**
 * Class ConfigReader
 *
 * @package API
 */

class ConfigReader
{

    /**
     * Array with configuration settings
     *
     * @var array
     */
    private $config;

    /**
     * ConfigReader constructor
     *
     */
    private function __construct() {  }

    /**
     * Load config file
     *
     * @param string $configFile path to your config file
     */
    public function load($configFile)
    {
        if (!file_exists($configFile)) {
            throw new \InvalidArgumentException("Can't find config file '$configFile'!");
        }

        $this->config = require_once($configFile);
    }

    /**
     * Read and return value from config file
     *
     * @param string $key
     * @return mixed value of config item
     */
    public function read($key)
    {
        if (!array_key_exists($key, $this->config)) {
            throw new \InvalidArgumentException("Config doesn't contain a setting for '$key'!");
        }

        return $this->config[$key];
    }

    public function getPageAccessToken()
    {
        return $this->read('page_access_token');
    }

    public function getDatabaseSettings()
    {
        return $this->read('database');
    }

    /**
     * @param string $driver database driver name
     * @return mixed
     */
    public function getDatabaseDriver(string $driver)
    {
        $drivers = $this->read('database')['drivers'];
        if (!array_key_exists($driver, $drivers)) {
            throw new \InvalidArgumentException("Config doesn't contain settings for driver '$driver'!");
        }

        return $drivers[$driver];
    }

    public function getVerificationToken()
    {
        return $this->read('verification_token');
    }

    public function getPrefix()
    {
        return $this->read('prefix');
    }

    public function isCaseSensitive()
    {
        return $this->read('case_sensitive');
    }

    public function isDebuggingEnabled()
    {
        return $this->read('debug');
    }

    /**
     * ConfigReader singleton
     *
     * @return ConfigReader instance
     */
    public static function getInstance()
    {
        static $instance = null;
        if ($instance == null) {
            $instance = new self();
        }
        return $instance;
    }
}
