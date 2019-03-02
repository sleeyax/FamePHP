<?php
require_once 'core/Bootstrap.php';

use Famephp\core\Response;
use Famephp\core\Sender;
use Famephp\core\attachments\Image;

$listener->hears('save image', function(Sender $sender, Response $response) {
    $response->assetManager->upload(new Image('D:\Downloads\dolphin.png;image/png', 'dolphin', true));
});
$listener->hears('get image', function(Sender $sender, Response $response) {
    $response->send(new Image($response->assetManager->retrieve('dolphin')));
});
