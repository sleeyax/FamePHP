<?php
namespace Famephp\core\buttons;
require_once 'Button.php';
use Famephp\core\buttons\Button;

class PostbackButton extends Button {
    
    private $title;
    private $payload;

    public function __construct($title, $payload) 
    {
        if (strlen($title) > 20) {
            throw new \InvalidArgumentException('Error: 20 character limit exceeded when creating button title!');
        }

        $this->type = 'postback';
        $this->title = $title;
        $this->payload = $payload;
    }

    public function GetJsonSerializable() 
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'payload' => $this->payload
        ];
    }
}
?>