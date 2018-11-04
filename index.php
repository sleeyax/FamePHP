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

// Load required components
require_once 'core/Bootstrap.php';
require_once ROOTDIR . 'core/attachments/Text.php';

// Specify modules you want to use
use Famephp\core\Response;
use Famephp\core\Sender;
use Famephp\core\attachments\Text;

$listener->hears('working?', function(Sender $sender, Response $response) {
    $response->Send(new Text("Yes it does, $sender->firstname! :D"));
});