<?php
/**
 * Reads & returns configuration file settings
 */
namespace Famephp\api;

class ConfigReader {
    
    private $config;

    /**
     * Constructor
     * @throws error
     */
    private function __construct() { /* Not allowed, use GetInstance() instead!*/}

    /**
     * Load config file
     *
     * @param string $configFile path
     * @throws \InvalidArgsException if file doesn't exist
     * @return void
     */
    public function Load($configFile) 
    {
         if (!file_exists($configFile)) {
            throw new \InvalidArgumentException("Can't load specified file '$configFile'!");
        }

        $this->config = require_once($configFile);
    }

    /**
     * Read value from config file
     *
     * @param string $key
     * @throws \InvalidArgsException when key doesn't exist
     * @return string value from $key
     */
    public function Read($key) {
        if (!array_key_exists($key, $this->config)) {
            throw new \InvalidArgumentException("Array key '$key' doesn't exist!");
        }

        return $this->config[$key];
    }

    /**
     * ConfigReader singleton
     * @return ConfigReader instance
     * @throws error
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