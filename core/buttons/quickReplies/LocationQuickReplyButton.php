<?php
namespace Famephp\core\buttons\QuickReplies;
require_once ROOTDIR . 'core/buttons/Button.php';
use Famephp\core\buttons\Button;

class LocationQuickReplyButton extends Button
{
    public function __construct() { $this->serializable['content_type'] = 'location'; }
}
?>