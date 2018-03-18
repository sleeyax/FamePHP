<?php
namespace Famephp\core\buttons\QuickReplies;
require_once ROOTDIR . 'core/buttons/Button.php';
use Famephp\core\buttons\Button;

class PhoneQuickReplyButton extends Button
{
    public function __construct() { $this->serializable['content_type'] = 'user_phone_number'; }
}
?>