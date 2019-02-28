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

/**
 * CallButton
 * @package Buttons
 */
class CallButton extends Button {

    /**
     * @var string button title
     */
    private $title;

    /**
     * @var string prefixed with '+', see fb docs
     */
    private $phoneNumber;

    /**
     * CallButton constructor.
     * @param $title
     * @param $phoneNr
     */
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

    /**
     * Get JSON serializable
     * @return array
     */
    public function getJsonSerializable()
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'payload' => $this->phoneNumber
        ];
    }
}
?>
