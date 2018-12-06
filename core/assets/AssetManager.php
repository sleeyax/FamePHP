<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
 *
 * @copyright Copyright (c) 2018 - 2018
 * @author Sleeyax (https://github.com/sleeyax)
 * @link https://github.com/sleeyax/FamePHP
 * @license https://github.com/sleeyax/FamePHP/blob/master/LICENSE
 */

namespace Famephp\core\assets;

use Famephp\api\db\DriverInterface;

/**
 * Class AssetManager
 * For storing & retrieving assets in the database
 *
 * @package Famephp\core\assets
 */
class AssetManager
{
    /**
     * @var DriverInterface
     */
    private $database;

    public function __construct(DriverInterface $database)
    {
        $this->database = $database;
    }


}