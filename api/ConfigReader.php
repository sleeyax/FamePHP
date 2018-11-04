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
     * Page access token
     *
     * @var string
     */
    public $pageAccessToken;

    /**
     * Verification token
     *
     * @var string
     */
    public $verificationToken;

    /**
     * Command prefix
     *
     * @var string
     */
    public $prefix;

    /**
     * Whether or not incoming commands are considered case sensitive
     *
     * @var bool
     */
    public $isCaseSensitive;

    /**
     * Whether or not the application should show debugging information
     *
     * @var bool
     */
    public $isDebuggingEnabled;

    /**
     * Array containing database connection settings
     *
     * @var array
     */
    public $db;

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

        $this->pageAccessToken = $this->config['page_access_token'];
        $this->verificationToken = $this->config['verification_token'];
        $this->prefix = $this->config['prefix'];
        $this->isCaseSensitive = $this->config['case_sensitive'];
        $this->db = $this->config['database'];
        $this->isDebuggingEnabled = $this->config['debug'];
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
            throw new \InvalidArgumentException("Array key '$key' doesn't exist!");
        }

        return $this->config[$key];
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
