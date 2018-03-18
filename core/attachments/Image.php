<?php
namespace Famephp\core\attachments;
require_once 'Attachment.php';

class Image extends Attachment {

   public function __construct($attachmentLocation, $attachmentName = null, $reusable = false) 
    {
        parent::__construct($attachmentLocation, $attachmentName, $reusable);
        $this->type = 'image';
    }
}
?>