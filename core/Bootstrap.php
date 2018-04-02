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

define('ROOTDIR', '');

require_once(ROOTDIR . 'core/User.php');
require_once(ROOTDIR . 'core/Message.php');
require_once(ROOTDIR . 'api/WebHook.php');

use Famephp\api\WebHook;

(new WebHook(ROOTDIR . 'api/Config.php'))->CreateNewHook();
