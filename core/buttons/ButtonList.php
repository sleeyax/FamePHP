<?php
namespace Famephp\core\buttons;

require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;
/**
 * Helper class for chaining a list of buttons
 */

class ButtonList implements JsonSerializable {

    private $buttonListSerializable = array();

    private $buttonCount = 0;

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

    public function GetButtonCount() { return $this->buttonCount; }

    public function GetJsonSerializable() 
    {
        return $this->buttonListSerializable;
    }
}
?>