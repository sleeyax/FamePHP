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
use Famephp\api\db\drivers\MysqlPdoDriver;
use Famephp\api\db\drivers\SqliteDriver;
use Famephp\api\GraphRequest;
use Famephp\core\attachments\Attachment;

/**
 * Send messages to user
 * @package Core
 */
class Response {

    /**
     * @var string messaging type
     * new since 7 May, 2018, see: https://developers.facebook.com/docs/messenger-platform/send-messages
     */
    private $type = "RESPONSE";

    /**
     * @var ConfigReader instance
     */
    private $config;

    /**
     * @var string recipient
     */
    private $recipientUserId;

    private $graph;

    /**
     * @var AssetManager asset
     */
    public $assetManager;

    /**
     * Response constructor.
     * @param $recipient
     */
    public function __construct($recipient)
    {
        $this->config = ConfigReader::getInstance();
        $this->graph = new GraphRequest($this->config->getPageAccessToken());
        $this->recipientUserId = $recipient;

        switch($this->config->getDatabaseDriver()) {
            case "mysql_pdo":
                $this->assetManager = new AssetManager(new MysqlPdoDriver(), $this->recipientUserId);
                break;
            case "sqlite":
                $this->assetManager = new AssetManager(new SqliteDriver(), $this->recipientUserId); //TODO: implement sqlite
                break;
            default:
                break;
        }
    }

    /**
     * Send a message to the user
     *
     * @param object $obj object to send
     * @return void
     */
    public function send(object $obj)
    {
        // Input check
        if (!is_object($obj)) {
            throw new \InvalidArgumentException('Send() failed: $obj must be an object!');
        }

        if (method_exists($obj, 'isLocalAttachment') && $obj->isLocalAttachment()) {
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
                    //'filename' => $obj->getName()
                ]
            ];

             $this->graph->postAttachment($payload);
        }else{
            $payload = [
                'messaging_type' => $this->type,
                'recipient' => [
                    'id' => $this->recipientUserId
                ],
                'message' => $obj->getJsonSerializable()
            ];

            $this->graph->postMessage($payload);
        }
    }

    /**
     * Toggle typing animation
     *
     * @param string $toggle on | off
     * @return void
     */
    private function isTyping($toggle = 'on') {
        if ($toggle != 'on' && $toggle != 'off') {
            exit('IsTyping() toggle failed: expected values are on or off');
        }

        $this->showAction("typing_$toggle");
    }

    public function startTyping() {
        $this->isTyping('on');
    }

    public function stopTyping() {
        $this->isTyping('off');
    }

    /**
     * Mark a user message as 'seen'
     *
     * @return void
     */
    public function MarkSeen() {
        $this->showAction('mark_seen');
    }

    /**
     * Set and send sender_action
     * @param $action
     */
    private function showAction($action) {
         $payload = [
            'recipient' => [
                'id' => $this->recipientUserId
            ],
            'sender_action' => $action
        ];

        $this->graph->postMessage($payload);
    }
}
