<?php
namespace Famephp\core\buttons;
require_once 'Button.php';
use Famephp\core\buttons\Button;

class CallButton extends Button {

    private $title;
    private $phoneNumber;

    public function __construct($title, $phoneNr) 
    {
        if (strlen($title) > 20) {
            throw new \InvalidArgumentException('Error: 20 character limit exceeded when creating button title!');
        }

        if (strpos($phoneNr, '+') === false) {
            throw new \InvalidArgumentException('Error: phone number must a "+" prefix followed by country code, area code and local number');
        }

        $this->type = 'phone_number';
        $this->title = $title;
        $this->phoneNumber = $phoneNr;
    }

    public function GetJsonSerializable()  
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'payload' => $this->phoneNumber
        ];
    }
}
?>