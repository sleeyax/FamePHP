<?php

define('ROOTDIR', '');

require_once(ROOTDIR . 'core/User.php');
require_once(ROOTDIR . 'core/Message.php');
require_once(ROOTDIR . 'api/WebHook.php');

use Famephp\api\WebHook;

(new WebHook(ROOTDIR . 'api/Config.php'))->CreateNewHook();

?>