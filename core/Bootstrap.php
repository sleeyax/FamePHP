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

define('ROOTDIR', '');
require_once ROOTDIR . 'vendor/autoload.php';

use Famephp\api\WebHook;
use Famephp\api\ConfigReader;
use Famephp\core\Listener;

$config = ConfigReader::getInstance();
$config->load(ROOTDIR . 'api/Config.php');

(new WebHook($config->getVerificationToken()))->create();

$listener = new Listener();