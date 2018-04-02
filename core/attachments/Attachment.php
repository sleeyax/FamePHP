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

namespace Famephp\core\attachments;

/**
 * Attachment extendable base class
 */
abstract class Attachment {
    /**
     * @var string attachment type
     */
    protected $type;

    /**
     * @var array Payload data
     */
    private $payload = array();
    
    /**
     * @var boolean Specifies whether or not the attachment is a local file on the computer
     */
    private $isLocalAttachment = false;

    /**
     * @var string location of attachment
     */
    private $localAttachmentLocation;

    /**
     * @var string mimetype of attachment
     */
    private $localAttachmentMimeType;
    
    /**
     * @var string | null The name of the attachment
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
     * @param string $attachment url | local file | attachment_id
     * @param string $attachmentName name of the attachment (local file only)
     * @param boolean $reusable specify whether or not the file will be reusable using attachment_id
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

    /**
     * Whether or not the attachment is reuasable
     * @return bool
     */
    public function IsReusable() {
        return $this->isReusable;
    }

    /**
     * Whether or not the attachment is locally stored on the computer
     * @return bool
     */
    public function IsLocalAttachment() 
    {
        return $this->isLocalAttachment;
    }

    /**
     * Return attachment location
     * @return string location
     */
    public function GetLocalAttachmentLocation() 
    {
        return $this->localAttachmentLocation;
    }

    /**
     * Return attachment mimetype
     * @return string
     */
    public function GetLocalAttachmentMimeType() 
    {
        return $this->localAttachmentMimeType;
    }

    /**
     * Return the name of the attachment
     * @return null | string
     */
    public function GetLocalAttachmentName() 
    {
        return $this->attachmentName;
    }

    /**
     * Alias for GetLocalAttachmentName()
     *
     * @return string $attachmentName
     */
    public function GetAttachmentName() {
        return $this->attachmentName;
    }

    /**
     * Return JSON serializable
     * @return array json serializable
     */
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