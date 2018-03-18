<?php
namespace Famephp\core\buttons;
require_once 'Button.php';
use Famephp\core\buttons\Button;

class ShareButton extends Button {
    
    /**
     * Contents of an alternative template to send when share button is clicked
     * -> Must be generic template object
     * -> Contains max. 1 URL button
     */
    private $shareContents;

    public function __construct($shareContents = null) 
    {
        $this->type = 'element_share';

        if (is_object($shareContents)) {
            $this->shareContents = $shareContents->GetJsonSerializable();
        }

        $this->BuildSerializable();
    }

    private function BuildSerializable() 
    {
        $this->serializable['type'] = $this->type;
        if (isset($this->shareContents)) {
            $this->serializable['share_contents'] = $this->shareContents;
        }
    }

}
?>