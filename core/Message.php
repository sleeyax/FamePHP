<?php
namespace Famephp\core;
require_once ROOTDIR . 'api/ConfigReader.php';
require_once ROOTDIR . 'api/WebHook.php';
require_once ROOTDIR . 'api/GraphRequest.php';
use Famephp\api\ConfigReader;
use Famephp\api\WebHook;
use Famephp\api\GraphRequest;
/**
 * Class for sending messages to the user (bot -> user)
 */

class Message {

    private $config;
    private $asset;
    private $recipient;

    public function __construct($recipient)
    {
        $this->config = ConfigReader::GetInstance();
        $this->graph = new GraphRequest($this->config->Read('page_access_token'));
        $this->recipient = $recipient;
    }

    /**
     * Create $this->asset property for later use
     *
     * @param array $databaseSettings from config or manually specified
     * @return void
     */
    public function NewAssetHandler($databaseSettings = null) {
        $databaseSettings = $databaseSettings ?? $this->config->Read('database');
        require_once (ROOTDIR . 'Asset.php');
        $this->asset = new Asset($databaseSettings);
    }

    /**
     * Upload an asset using $this->Send() Attachment API
     *
     * @param object $attachment
     * @return void
     */
    public function UploadAsset($attachment) {
        $this->Send($attachment, 'message_attachments');
    }

    /**
     * Send a message to the user
     * Supports both Attachment Upload API & Send API
     * 
     * Attachment upload API
     * -> $graphSection = 'message_attachments'
     * 
     * Send API
     * -> $graphSection = 'message'
     * 
     * @param object $obj object
     * @param string $graphSection messages|message_attachments
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

        // DEBUGGING
        if ($this->config->Read('DEBUG') == true) {
            if (is_array($toSend)) {
                print_r($toSend);
            }else{
                echo $toSend;
            }
        }
        
        // Send request
        $this->graph->OpenSession();
        $this->graph->SetGraphSection($graphSection);
        $response = $this->graph->Post($toSend);
        $this->graph->CloseSession();
        
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
     * Show 'typing...' animation or not
     *
     * @param string $toggle on|off
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

    private function SaveAsset($assetName, $assetId) 
    {
        if ($this->asset == null) {
            $this->NewAssetHandler();
        }
        return $this->asset->Save($assetName, $assetId);
    }

    public function GetAsset($assetName) 
    {
        if ($this->asset == null) {
            $this->NewAssetHandler();
        }
        return $this->asset->Get($assetName);
    }
}
?>