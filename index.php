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

// Load required components
require_once 'core/Bootstrap.php';
use Famephp\core\User;
use Famephp\core\Message;

// Specify modules we want to use
require_once ROOTDIR . 'core/attachments/Text.php';
use Famephp\core\attachments\Text;

// Read message & Send response
$user = new User();
$message = new Message($user->GetInfo(true)['id']);

if ($user->GetMessageText() == "test")
{
    $message->Send(
        new Text('Congratulations! This bot has been configured correctly :D')
    );
}
?>