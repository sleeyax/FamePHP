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

namespace Famephp\core\buttons;
require_once 'Button.php';
use Famephp\core\buttons\Button;
use Famephp\core\templates\GenericTemplate;

/**
 * ShareButton
 * @package Buttons
 */
class ShareButton extends Button {
    /**
     * Contents of an alternative template to send when share button is clicked
     * @var GenericTemplate object
     */
    private $shareContents;

    /**
     * ShareButton constructor.
     * @param null $shareContents
     */
    public function __construct($shareContents = null) 
    {
        $this->type = 'element_share';

        if (is_object($shareContents)) {
            $this->shareContents = $shareContents->GetJsonSerializable();
        }

        $this->BuildSerializable();
    }

    /**
     * Build the JSON serializable (content is stored in parent's $this->serializable)
     */
    private function BuildSerializable() 
    {
        $this->serializable['type'] = $this->type;
        if (isset($this->shareContents)) {
            $this->serializable['share_contents'] = $this->shareContents;
        }
    }

}
?>