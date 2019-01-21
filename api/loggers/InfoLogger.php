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

/**
 * Class InfoLogger
 *
 * @package Famephp\api\loggers
 */
class InfoLogger extends BaseLogger
{

    public function __construct()
    {
        $this->name = 'info-logger';
        $this->fileName = 'info.log';
        $this->level = Logger::INFO;

        $this->create();
    }

    public function getName()
    {
        return $this->name;
    }

    public function log(string $text)
    {
        $this->logger->info($text);
    }
}
