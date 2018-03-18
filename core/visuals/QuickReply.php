<?php
namespace Famephp\core\visuals;

require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;

class QuickReply implements JsonSerializable {
    
    private $jsonSerializable;

    /**
     * Constructor
     *
     * @param object $preamble
     * @param ButtonList object $quickReplies
     */
    public function __construct($preamble, $quickRepliesButtonList)
    {
        if (!is_object($preamble)) {
            throw new \InvalidArgumentException('Failed to create QuickReply: $preamble must be an attachment or text object');
        }
        if (!is_object($quickRepliesButtonList)) {
            throw new \InvalidArgumentException('Failed to create QuickReply: $quickReplies must be a ButtonList of QuickReplyButtons');
        }
        
        $this->jsonSerializable = $preamble->GetJsonSerializable();
        $this->jsonSerializable['quick_replies'] = $quickRepliesButtonList->GetJsonSerializable();
    }
    public function GetJsonSerializable() 
    {
        return $this->jsonSerializable;
    }
}
?>