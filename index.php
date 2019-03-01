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

require_once 'core/Bootstrap.php';

// Specify modules you want to use
use Famephp\core\attachments\Image;
use Famephp\core\buttons\ButtonList;
use Famephp\core\buttons\URLButton;
use Famephp\core\Response;
use Famephp\core\Sender;
use Famephp\core\attachments\Text;
use Famephp\core\templates\ButtonTemplate;
use Famephp\core\templates\GenericTemplate;
use Famephp\core\templates\ListTemplate;

$listener->hears('working?', function(Sender $sender, Response $response) {
    $response->send(new Text("Yes it does, $sender->firstname! :D"));
});

$listener->hears('img', function($sender, Response $response) {
    $response->startTyping();
    $response->send(new Image('https://i.imgur.com/CuVQGg3.jpg'));
    $response->stopTyping();
});

$listener->hears('asset', function($sender, Response $response) {
   $response->assetManager->upload(new Image('D:\Downloads\dolphin.png;image/png', null, true));
});

$listener->hears('qrep', function($sender, Response $response) {
    $response->send(new \Famephp\core\visuals\QuickReply(
        new Text('Favorite color?'),
        new \Famephp\core\buttons\ButtonList(
            new \Famephp\core\buttons\QuickReplies\TextQuickReplyButton('red', 'qrep-red', 'https://i.imgur.com/L8n9abb.png'),
            new \Famephp\core\buttons\QuickReplies\TextQuickReplyButton('blue', 'qrep-blue', 'https://i.imgur.com/L8n9abb.png')
        )
    ));
});
$listener->hearsWhisper('qrep-red', function($sender, Response $response) {
    $response->send(new Text('red is the best choice, indeed'));
});

$listener->hears('a', function (Sender $sender, Response $response) {
    $response->send(new ListTemplate(
        array(
            [
                'title' => 'Pecan tree',
                'subtitle' => 'Common tree',
                'image' => 'https://i.imgur.com/QwUimsd.jpg',
                'onclick' => new URLButton(null, 'https://en.wikipedia.org/wiki/Pecan'),
                'buttons' => new ButtonList(
                    new URLButton('Buy', 'https://shop.arborday.org/product.aspx?zpid=897')
                )
            ],
            [
                'title' => 'Ash tree',
                'subtitle' => 'A nice tree. Very nice',
                'image' => 'https://i.imgur.com/7EZbzbM.jpg',
                'onclick' => new URLButton(null, 'http://www.2020site.org/trees/ash.html')
            ]
        ),
        new URLButton('View more', 'http://tree-pictures.com/tree_types.html')
    ));
});
