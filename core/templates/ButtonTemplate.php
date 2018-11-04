<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\core\templates;
require_once 'Template.php';
use Famephp\core\templates\Template;
use Famephp\core\buttons\ButtonList;

/**
 * Class ButtonTemplate
 * @package Templates
 */
class ButtonTemplate extends Template {
    /**
     * Text to send with buttons
     *
     * @var string
     */
    private $text;

    /**
     * Array of button elements
     *
     * @var array
     */
    private $buttons;

    /**
     * ButtonTemplate constructor.
     * @param $text
     * @param ButtonList $buttonsList
     */
    public function __construct($text, ButtonList $buttonsList)
    {
        if (strlen($text) > 640) {
            throw new \InvalidArgumentException('$text can\'t be more than 640 chars long!');
        }

        if ($buttonsList->GetButtonCount() < 1 || $buttonsList->GetButtonCount() > 3) {
            throw new \InvalidArgumentException('amount of buttons in $buttonsList must be between 1 and 3 when using Buttontemplates!');
        }

        $this->type = 'button';
        $this->text = $text;
        $this->buttons = $buttonsList->GetJsonSerializable();
    }

    /**
     * Get JSON serializable
     * @return array
     */
    public function GetJsonSerializable() 
    {
        return [
           'attachment' => [
               'type' => 'template',
               'payload' => [
                   'template_type' => $this->type,
                   'text' => $this->text,
                   'buttons' => $this->buttons
               ]
           ] 
        ];
    }
}
?>