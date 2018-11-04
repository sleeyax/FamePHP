<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

define('ROOTDIR', '');

require_once(ROOTDIR . 'core/User.php');
require_once(ROOTDIR . 'core/Response.php');
require_once(ROOTDIR . 'api/WebHook.php');
require_once(ROOTDIR . 'core/Listener.php');
require_once(ROOTDIR . 'core/Sender.php');

use Famephp\api\WebHook;
use Famephp\api\ConfigReader;
use Famephp\core\Listener;

$config = ConfigReader::getInstance();
$config->load(ROOTDIR . 'api/Config.php');

(new WebHook($config->verificationToken))->create();

$listener = new Listener();