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

namespace Famephp\core\contracts;
/**
 * Interface JsonSerializable
 * @package Contracts
 */
interface JsonSerializable 
{
    /**
     * JSON serializable
     * @return array
     */
    public function getJsonSerializable();
}
