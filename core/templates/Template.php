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

namespace Famephp\core\templates;
require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;

/**
 * Extendable abstract Class Template
 * @package Templates
 */
abstract class Template implements JsonSerializable 
{
    /**
     * @var string Template tye
     */
    protected $type;

    /**
     * @var array data to send
     */
    protected $payload = array();

    /**
     * Get JSON serializable
     * @return array
     */
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