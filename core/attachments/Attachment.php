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

namespace Famephp\core\attachments;

use http\Exception\InvalidArgumentException;

/**
 * Attachment extendable base class
 *
 * @package Attachments
 */
abstract class Attachment {
    /**
     * @var string attachment type
     */
    protected $type;

    /**
     * @var array payload data
     */
    private $payload = array();
    
    /**
     * @var boolean specifies whether or not the attachment is a local file on the computer
     */
    private $isLocal = false;

    /**
     * @var string location of attachment
     */
    private $location;

    /**
     * @var string mimetype of attachment
     */
    private $mimeType;
    
    /**
     * @var mixed the name of the attachment (null | string)
     */
    private $name;

    /**
     * @var boolean attachment re-use policy
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
        $this->isReusable = $reusable;
        $this->name = $attachmentName;

        switch ($attachment) {
            case preg_match('/https{0,1}:\/\//', $attachment) == 1: // URL
                $this->payload['url'] = $attachment;
                $this->payload['is_reusable'] = $reusable;
                break;
            case ctype_digit($attachment): // attachment_id
                $this->payload['attachment_id'] = $attachment;
                break;
            default: // File
                $this->payload['is_reusable'] = $reusable;
                $this->isLocal = true;
                $parts = explode(';', $attachment);
                if (count($parts) < 2) {
                    throw new \InvalidArgumentException('File MimeType not specified!');
                }
                $this->location = $parts[0];
                $this->mimeType = $parts[1];
                $this->name = ($attachmentName == null) ? pathinfo($this->location, PATHINFO_FILENAME) : $attachmentName;
                break;
        }
    }

    /**
     * Whether or not the attachment is reuasable
     * @return bool
     */
    public function isReusable() {
        return $this->isReusable;
    }

    /**
     * Whether or not the attachment is locally stored on the computer
     * @return bool
     */
    public function isLocalAttachment()
    {
        return $this->isLocal;
    }

    /**
     * Return attachment location
     * @return string location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Return attachment mimetype
     * @return string file mime type
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Return the name of the attachment
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the attachment type
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Return JSON serializable
     * @return array json serializable
     */
    public function getJsonSerializable()
    {
        return [
            'attachment' => [
                'type' => $this->type,
                'payload' => $this->payload
            ]
        ];
    }
}
