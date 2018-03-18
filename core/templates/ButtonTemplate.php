<?php
namespace Famephp\core\templates;
require_once 'Template.php';
use Famephp\core\templates\Template;
use Famephp\core\buttons\ButtonList;

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