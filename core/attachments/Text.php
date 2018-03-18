<?php
namespace Famephp\core\attachments;
require_once 'Attachment.php';

class Text extends Attachment {
    
    private $text;
    
    public function __construct($text) 
    {
        $this->text = $text;
    }

    public function GetAttachmentName() { return null; }

    public function IsLocalAttachment() { return false; }

    public function GetJsonSerializable() 
    {
        return [ 'text' => $this->text ];
    }
}
?>