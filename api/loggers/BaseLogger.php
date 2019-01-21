<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2019
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\api\loggers;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

abstract class BaseLogger
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var int
     */
    protected $level;

    public function __construct() {}

    /**
     * Creates the logger
     */
    protected function create()
    {
        try {
            $this->logger = new Logger($this->name);
            $this->logger->pushHandler(new StreamHandler(ROOTDIR . "/logs/$this->fileName", $this->level));
        }catch(\Exception $ex) {
            echo "Failed to create logger $this->name! Caught exception: $ex";
        }
    }

    /**
     * Child class must specify a logger name
     * @return mixed
     */
    public abstract function getName();

    /**
     * Child class must implement a method to log text
     *
     * @param string $text
     * @return mixed
     */
    public abstract function log(string $text);
}
