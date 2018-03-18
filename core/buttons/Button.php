<?php
namespace Famephp\core\buttons;

require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;

abstract class Button implements JsonSerializable {
    protected $serializable = array();
    protected $type;
    public function GetJsonSerializable() { return $this->serializable; }
}
?>