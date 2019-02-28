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
require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;
/**
 * Helper class for chaining a list of buttons
 * @package Buttons
 */
class ButtonList implements JsonSerializable {

    /**
     *  Array of serializable buttons
     * @var array $buttonListSerializable
     */
    private $buttonListSerializable = array();

    /**
     * Amount of buttons is list
     * @var int $buttonCount
     */
    private $buttonCount = 0;

    /**
     * ButtonList constructor.
     */
    public function __construct() 
    {
        for ($i=0; $i<func_num_args(); $i++) 
        {
            $obj = func_get_arg($i);
            
            if (!is_object($obj)) {
                throw new \InvalidArgumentException('ButtonList can only contain button objects!');
            }

            $this->buttonListSerializable[] = $obj->GetJsonSerializable();
            $this->buttonCount++;
        }
    }

    /**
     * Returns amount of buttons in list
     * @return int
     */
    public function GetButtonCount() { return $this->buttonCount; }

    /**
     * Get JSON serializable
     * @return array
     */
    public function getJsonSerializable()
    {
        return $this->buttonListSerializable;
    }
}
?>
