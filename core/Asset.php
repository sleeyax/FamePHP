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

namespace Famephp\core;
require_once ROOTDIR . 'api/ConfigReader.php';
require_once ROOTDIR . 'api/Database.php';
use Famephp\api\ConfigReader;
use Famephp\api\Database;

/**
 * Get and retrieve message assets from database
 * @package Core
 */
class Asset {
    /**
     * @var Database connection instance
     */
    private $db;

    /**
     * Asset constructor.
     * @param $dbCredentials database credentials
     */
    public function __construct($dbCredentials) 
    {
        $this->db = new Database(
            $dbCredentials['host'],
            $dbCredentials['dbname'],
            $dbCredentials['username'],
            $dbCredentials['password']
        );
    }

    /**
     * Save asset to db
     *
     * @param string $assetName
     * @param int | string $assetId
     * @return bool
     */
    public function Save($assetName, $assetId) 
    {
        if (!$this->db->Select('Id', 'assets', 'Name=:name', [':name' => $assetName])) {
            exit('Can not save asset: Error in SQL query!');
        }

        $row = $this->db->FetchRow();

        if (empty($row)) 
        {
            $this->db->Insert('assets', 
                ['Name', 'Attachmentid'],
                [':name' => $assetName, ':attachmentid' => $assetId]
            );
        }
        else
        {
            $this->db->Update('assets', 'Attachmentid=:attachmentid', 'Id=:id', [
                ':attachmentid' => $assetId,
                ':id' => $row['Id']
            ]);
        }

        return ($this->db->AffectedRows() > 0) ? true : false; 
        
    }

    /**
     * Retrieve saved asset from database
     *
     * @param string $assetName
     * @return string $attachmentId
     */
    public function Get($assetName) 
    {
        $this->db->Select('Attachmentid', 'assets', 'Name=:assetname', [
            ':assetname' => $assetName
        ]);

        $row = $this->db->FetchRow();

        if (empty($row)) {
            exit('Failed to retrieve asset from database!');
        }

        return $row['Attachmentid'];
    }
}
?>