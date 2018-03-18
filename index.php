<?php
// Load required components
require_once 'core/Bootstrap.php';
use Famephp\core\User;
use Famephp\core\Message;

// Specify modules we want to use
require_once ROOTDIR . 'core/visuals/QuickReply.php';
require_once ROOTDIR . 'core/buttons/quickReplies/TextQuickReplyButton.php';
require_once ROOTDIR . 'core/buttons/quickReplies/PhoneQuickReplyButton.php';
require_once ROOTDIR . 'core/buttons/ButtonList.php';
require_once ROOTDIR . 'core/attachments/Text.php';
use Famephp\core\visuals\QuickReply;
use Famephp\core\buttons\quickReplies;
use Famephp\core\buttons\ButtonList;
use Famephp\core\attachments\Text;

// Read message & Send response
$user = new User();
$message = new Message($user->GetInfo(true)['id']);

if ($user->GetMessageText() == "qrep")
{
    $message->Send(
        new QuickReply(new Text('Choose your favorite colors: '), new ButtonList(
            new QuickReplies\PhoneQuickReplyButton(),
            new QuickReplies\TextQuickReplyButton('Blue', 'btn-blue', 'https://i.imgur.com/p8muIQC.png')
        ))
    );
}
?>