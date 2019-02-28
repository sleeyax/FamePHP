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
 * PostbackButton
 * @package Buttons
 */
class PostbackButton extends Button {

    /**
     * @var string button title
     */
    private $title;

    /**
     * @var string data to send
     */
    private $payload;

    /**
     * PostbackButton constructor.
     * @param $title
     * @param $payload
     */
    public function __construct($title, $payload) 
    {
        if (strlen($title) > 20) {
            throw new \InvalidArgumentException('Error: 20 character limit exceeded when creating button title!');
        }

        $this->type = 'postback';
        $this->title = $title;
        $this->payload = $payload;
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
            'payload' => $this->payload
        ];
    }
}
?>
