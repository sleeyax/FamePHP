<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\core\buttons;

require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;

/**
 * Base extendable abastract Button class
 * @package Buttons
 */
abstract class Button implements JsonSerializable {
    /**
     * @var array JSON serializable
     */
    protected $serializable = array();

    /**
     * @var string $type type of button
     */
    protected $type;

    /**
     * Get JSON serializable
     * @return array
     */
    public function GetJsonSerializable() { return $this->serializable; }
}
?>