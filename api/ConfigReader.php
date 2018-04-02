<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\api;

/**
 * Class ConfigReader
 * @package API
 */

class ConfigReader {

    /**
     * Array with configuration settings
     * @var
     */
    private $config;

    /**
     * ConfigReader constructor
     */
    private function __construct() { /* Not allowed, use GetInstance() instead!*/}

    /**
     * Load config file
     * @param string $configFile path to your config file
     */
    public function Load($configFile) 
    {
         if (!file_exists($configFile)) {
            throw new \InvalidArgumentException("Can't load specified file '$configFile'!");
        }

        $this->config = require_once($configFile);
    }

    /**
     * Read and return value from config file
     *
     * @param string $key
     * @return mixed
     */
    public function Read($key) {
        if (!array_key_exists($key, $this->config)) {
            throw new \InvalidArgumentException("Array key '$key' doesn't exist!");
        }

        return $this->config[$key];
    }

    /**
     * ConfigReader singleton
     * @return ConfigReader $instance
     */
    public static function GetInstance() {
        static $instance = null;
        if ($instance == null) {
            $instance = new self();
        }
        return $instance;
    }
}
?>