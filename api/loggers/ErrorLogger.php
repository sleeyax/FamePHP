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
 * Class ErrorLogger
 *
 * @package Famephp\api\loggers
 */
class ErrorLogger extends BaseLogger
{
      public function __construct()
      {
          $this->name = 'error-logger';
          $this->fileName = 'error.log';
          $this->level = Logger::WARNING;

          $this->create();
      }

      public function getName()
      {
          return $this->name;
      }

      public function log(string $text)
      {
          $this->logger->error($text);
      }
}

