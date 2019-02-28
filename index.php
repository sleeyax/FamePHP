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

// Load required components
require_once 'core/Bootstrap.php';
require_once ROOTDIR . 'core/attachments/Text.php';

// Specify modules you want to use
use Famephp\core\attachments\Image;
use Famephp\core\Response;
use Famephp\core\Sender;
use Famephp\core\attachments\Text;

$listener->hears('working?', function(Sender $sender, Response $response) {
    $response->send(new Text("Yes it does, $sender->firstname! :D"));
});

$listener->hears('img', function($sender, Response $response) {
    $response->send(new Image('D:\Downloads\dolphin2.png;image/png'));
});

$listener->hears('on', function($sender, Response $response) {
    $response->startTyping();
});

$listener->hears('off', function($sender, Response $response) {
    $response->stopTyping();
});

$listener->hears('asset', function($sender, Response $response) {
   $response->assetManager->upload(new Image('D:\Downloads\dolphin.png;image/png', null, true));
});
