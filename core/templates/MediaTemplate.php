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

namespace Famephp\core\templates;
require_once 'Template.php';

/**
 * Class MediaTemplate
 * @package Templates
 */
class MediaTemplate extends Template {
    /**
     * Media type
     *
     * @var string image | video
     */
    private $mediaType;

    /**
     * facebook URL of media
     *
     * @var string
     */
    private $url;

    /**
     * Attchment id of media (see: attachment upload API in Asset.php)
     *
     * @var int
     */
    private $attachmentId;

    /**
     * Buttonlist
     *
     * @var object
     */
    private $buttons;

    /**
     * MediaTemplate constructor.
     * @param string | int $media - can be attachment_id or URL
     * @param object | null $buttons
     * @param bool $isVideo - whether or not the url/id is a video
     */
    public function __construct($media, $buttons = null, $isVideo = true)
    {
        if (isset($buttons)) 
        {
            if (!is_object($buttons)) {
                throw new \InvalidArgumentException('$button must be a ButtonList object');
            }

            if ($buttons->GetButtonCount() > 1) {
                throw new \InvalidArgumentException('max. 1 $button supported when using Media templates!');
            }
        }
        
        $this->type = 'media';
        $this->mediaType = ($isVideo) ? 'video' : 'image';
        if (strpos($media, 'http') !== false) {
            $this->url = $media;
        }else{
            $this->attachmentId = $media;
        }
        $this->buttons = ($buttons != null) ? $buttons->GetJsonSerializable() : null;
        
        $this->preparePayload();
    }

    /**
     * Prepare payload for sending
     */
    private function preparePayload()
    {
        $this->payload['template_type'] = $this->type;
        $this->payload['elements'][0]['media_type'] = $this->mediaType;
        
        if (isset($this->attachmentId)) {
            $this->payload['elements'][0]['attachment_id'] = $this->attachmentId;
        }else{
            $this->payload['elements'][0]['url'] = $this->url;
        }

        if ($this->buttons != null) {
            $this->payload['elements'][0]['buttons'] = $this->buttons;
        }
    }
}

