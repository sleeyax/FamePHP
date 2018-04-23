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
require_once ROOTDIR . 'api/WebHook.php';
require_once ROOTDIR . 'api/GraphRequest.php';
use Famephp\api\ConfigReader;
use Famephp\api\WebHook;
use Famephp\api\GraphRequest;

/**
 * Send messages to user
 * @package Core
 */
class Message {

    /**
     * @var string messaging type
     * new since 7 May, 2018, see: https://developers.facebook.com/docs/messenger-platform/send-messages
     */
    private $type;

    /**
     * @var ConfigReader instance
     */
    private $config;

    /**
     * @var Message asset
     */
    private $asset;

    /**
     * @var Message recipient
     */
    private $recipient;

    /**
     * Message constructor.
     * @param $recipient
     * @param string $type response type RESPONSE | UPDATE | MESSAGE_TAG
     */
    public function __construct($recipient, $type = "RESPONSE")
    {
        $this->config = ConfigReader::GetInstance();
        $this->graph = new GraphRequest($this->config->Read('page_access_token'));
        $this->recipient = $recipient;
        $this->type = $type;
    }

    /**
     * Create asset property for later use
     *
     * @param array $databaseSettings from config or manually specified (optional)
     * @return void
     */
    public function NewAssetHandler($databaseSettings = null) {
        $databaseSettings = $databaseSettings ?? $this->config->Read('database');
        require_once (ROOTDIR . 'Asset.php');
        $this->asset = new Asset($databaseSettings);
    }

    /**
     * Upload an asset using attachment API
     *
     * @param object $attachment
     * @return void
     */
    public function UploadAsset($attachment) {
        $this->Send($attachment, 'message_attachments');
    }

    /**
     * Send a message to the user
     *
     * @param object $obj object to send
     * @param string $graphSection API messages | message_attachments
     * @return void
     */
    public function Send($obj, $graphSection = 'messages')
    {
        // Iput check
        if (!is_object($obj)) {
            throw new \InvalidArgumentException('Send() failed: $obj must be an object!');
        }

        // Build payload
        $payload = [
            'messaging_type' => $this->type,
            'recipient' => [
                'id' => $this->recipient
            ],
            'message' => $obj->GetJsonSerializable()
        ];

        // Encode request (attachments)
        $toSend = json_encode($payload);
        if (method_exists($obj, 'IsLocalAttachment'))
        {
            if ($obj->IsLocalAttachment()) 
            {
                $this->graph->SetContentType('multipart/form-data');

                $toSend = [
                    'recipient' => json_encode($payload['recipient']),
                    'message' => json_encode($payload['message']),
                    'filedata' => new \CURLFile(
                        $obj->GetLocalAttachmentLocation(),
                        $obj->GetLocalAttachmentMimeType(),
                        $obj->GetLocalAttachmentName()
                    )
                ];
            }
        }



        // Send request
        $this->graph->OpenSession();
        $this->graph->SetGraphSection($graphSection);
        $response = $this->graph->Post($toSend);
        $this->graph->CloseSession();

        /// DEBUGGING
        if ($this->config->Read('DEBUG') == true) {
            if (is_array($toSend)) {
                print_r($toSend);
            }else{
                echo $toSend;
            }
            echo $response;
        }
        
        // Save asset (attachments)
        $attachmentName = null;
        if (method_exists($obj, 'GetAttachmentName')) {
            $attachmentName = $obj->GetAttachmentName();
        }
        
        if ($attachmentName != null)
        {
            $assetId = json_decode($response, true)['attachment_id'] ?? null;

            if ($assetId == null) 
            {
                exit('$response data doesn\'t contain an attachment_id!');
            }

            $this->SaveAsset($attachmentName, $assetId);
        }   
    }

    /**
     * Toggle typing animation
     *
     * @param string $toggle on | off
     * @return void
     */
    public function IsTyping($toggle = 'on') {
        if ($toggle != 'on' && $toggle != 'off') {
            exit('IsTyping() toggle failed: expected values are on or off');
        }

        $this->SenderAction("typing_$toggle");
    }

    /**
     * Mark a user message as 'seen'
     *
     * @return void
     */
    public function MarkSeen() {
        $this->SenderAction('mark_seen');
    }

    /**
     * Set and send sender_action
     * @param $action
     */
    private function SenderAction($action) {
         $payload = [
            'recipient' => [
                'id' => $this->recipient
            ],
            'sender_action' => $action
        ];

        $this->graph->OpenSession();
        $this->graph->Post(json_encode($payload));
        $this->graph->CloseSession();
    }

    /**
     * Save message asset to database
     * @param $assetName
     * @param $assetId
     * @return mixed
     */
    private function SaveAsset($assetName, $assetId) 
    {
        if ($this->asset == null) {
            $this->NewAssetHandler();
        }
        return $this->asset->Save($assetName, $assetId);
    }

    /**
     * Get message asset from database
     * @param $assetName
     * @return mixed asset
     */
    public function GetAsset($assetName) 
    {
        if ($this->asset == null) {
            $this->NewAssetHandler();
        }
        return $this->asset->Get($assetName);
    }
}
?>