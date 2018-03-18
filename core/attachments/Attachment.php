<?php
namespace Famephp\core\attachments;

abstract class Attachment {
    /**
     * attachment type
     *
     * @var string
     */
    protected $type;

    /**
     * Payload data
     *
     * @var array
     */
    private $payload = array();
    
    /**
     * Specifies whether or not the attachment is a local file on the computer
     *
     * @var boolean
     */
    private $isLocalAttachment = false;
    private $localAttachmentLocation;
    private $localAttachmentMimeType;
    
    /**
     * The name of the attachment
     *
     * @var string|null
     */
    private $attachmentName;

    /**
     * Attachment re-use policy
     *
     * @var boolean whether or not the attachment is reuasable
     */
    private $isReusable;

    /**
     * Constructor
     *
     * @param string $attachment url|local file|attachment_id
     * @param string $attachmentName name of the attachment (local file only)
     * @param boolean $reusable specify whether or not the file will be reusable using its attachment_id
     */
    protected function __construct($attachment, $attachmentName, $reusable)
    {
        if ($reusable == true && empty($attachmentName))
        {
            throw new \InvalidArgumentException('$attachmentName can\'t be empty when using reusable attachments!');
        }

        $this->isReusable = $reusable;
        $this->attachmentName = $attachmentName;

        switch ($attachment) {
            case preg_match('/https{0,1}:\/\//', $attachment) == 1: // URL
                $this->payload['url'] = $attachment;
                $this->payload['is_reusable'] = $reusable;
                break;
            case ctype_digit($attachment) == true: // attachment_id
                $this->payload['attachment_id'] = $attachment;
                break;
            default: // File
                $this->payload['is_reusable'] = $reusable;
                $this->isLocalAttachment = true;
                $parts = explode(';', $attachment);
                $this->localAttachmentLocation = $parts[0];
                $this->localAttachmentMimeType = $parts[1];
                $this->attachmentName = ($attachmentName == null) ? $this->localAttachmentLocation : $attachmentName;
                break;
        }
    }

    public function IsReusable() {
        return $this->isReusable;
    }

    public function IsLocalAttachment() 
    {
        return $this->isLocalAttachment;
    }

    public function GetLocalAttachmentLocation() 
    {
        return $this->localAttachmentLocation;
    }

    public function GetLocalAttachmentMimeType() 
    {
        return $this->localAttachmentMimeType;
    }
    public function GetLocalAttachmentName() 
    {
        return $this->attachmentName;
    }

    /**
     * Alias for GetLocalAttachmentName()
     *
     * @return string $this->attachmentName
     */
    public function GetAttachmentName() {
        return $this->attachmentName;
    }

    public function GetJsonSerializable() 
    {
        return [
            'attachment' => [
                'type' => $this->type,
                'payload' => $this->payload
            ]
        ];
    }
}
?>