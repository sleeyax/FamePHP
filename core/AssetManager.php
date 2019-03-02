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

namespace Famephp\core;

use Famephp\api\ConfigReader;
use Famephp\api\db\drivers\DriverInterface;
use Famephp\api\GraphRequest;
use Famephp\core\attachments\Attachment;

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

    private $graph;

    private $recipientUserId;

    /**
     * AssetManager constructor.
     *
     * @param DriverInterface $database
     * @param                 $recipientUserId
     */
    public function __construct(DriverInterface $database, $recipientUserId)
    {
        $this->database = $database;
        $config = ConfigReader::getInstance();
        $this->graph = new GraphRequest($config->getPageAccessToken());
        $this->recipientUserId = $recipientUserId;
    }

    /**
     * Change the database driver
     *
     * @param $database
     */
    public function useDriver($database)
    {
        $this->database = $database;
    }

    public function retrieve(string $name)
    {
        $this->database->select('assets', ['Attachmentid'], 'Name=:Name', [':Name' => $name]);
        $row = $this->database->fetchRow();

        return $row['Attachmentid'] ?? null;
    }

    /**
     * Store attachment on facebook's server for later use
     *
     * @param Attachment $obj
     * @return bool
     */
    public function upload(Attachment $obj)
    {
        if (!$obj->isLocalAttachment()) {
            throw new \InvalidArgumentException('Attachment must be local!');
        }

        $payload = [
            [
                'name' => 'recipient',
                'contents' => json_encode(['id' => $this->recipientUserId])
            ],
            [
                'name' => 'message',
                'contents' => json_encode($obj->getJsonSerializable())
            ],
            [
                'name' => 'filedata',
                'contents' => fopen($obj->getLocation(), 'r'),
                // 'filename' => $obj->getName()
            ]
        ];

        $response = json_decode($this->graph->uploadAttachment($payload), true);
        $attachmentId = $response['attachment_id'];

        $this->database->select('assets', ['Attachmentid, Name'], 'Name=:Name', [':Name' => $obj->getName()]);
        $row = $this->database->fetchRow();

        if(empty($row)) {
           $this->database->insert('assets', ['Attachmentid', 'Name'], [
                ':aid' => [$attachmentId, \PDO::PARAM_STR],
                ':name' => [$obj->getName(), \PDO::PARAM_STR]
            ]);
        }else{
            $this->database->update('assets', 'Attachmentid=:aid', 'Name=:name', [
                ':name' => [$row['Name'], \PDO::PARAM_STR],
                ':aid' => [$attachmentId, \PDO::PARAM_STR]
            ]);
        }

        return ($this->database->countAffectedRows() > 0) ? true : false;
    }
}
