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
use Famephp\core;

// Specify modules you want to use
require_once ROOTDIR . 'core/attachments/Text.php';
use Famephp\core\attachments\Text;

// Initialize user
$user = new Core\User();

// Create message object
$message = new Core\Message($user->GetInfo()['id']);

// Read message & send reply
if ($user->GetMessageText() == "hello") {
    $firstname = $user->GetInfo()['first_name'];
    $message->Send(
        new Text("Hi, $firstname")
    );
}