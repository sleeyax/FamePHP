<?php
namespace Famephp\core\templates;

require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;

abstract class Template implements JsonSerializable 
{
    protected $type;
    protected $payload = array();
    public function GetJsonSerializable() 
    {
        return [
           'attachment' => [
               'type' => 'template',
               'payload' => $this->payload
           ] 
        ];
    }
}
?>