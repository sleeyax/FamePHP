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

namespace Famephp\core\buttons\QuickReplies;
require_once ROOTDIR . 'core/buttons/Button.php';
use Famephp\core\buttons\Button;

/**
 * Class TextQuickReplyButton
 * @package QuickReplies
 */
class TextQuickReplyButton extends Button {

    /**
     * Button title (amount of chars <= 20)
     *
     * @var string
     */
    protected $title;

    /**
     * Image URL with a minimun size of 24px x 24px (optional)
     *
     * @var string
     */
    protected $imageURL;

    /**
     * Postback payload
     *
     * @var string
     */
    protected $payload;

    /**
     * Constructor
     *
     * @param string $title
     * @param string $payload
     * @param string $url
     */
    public function __construct($title, $payload, $url = null)
    {
        if (strlen($title) > 20) {
            throw new \InvalidArgumentException('$title exceeded max chars count of 20');
        }

        $this->title = $title;
        $this->payload = $payload;
        if ($url != null) {
            $this->imageURL = $url;
        }

        $this->BuildSerializable();
    }

    /**
     * Builds the JSON serializable
     */
    protected function BuildSerializable()
    {
        $this->serializable = [
            'content_type' => 'text',
            'title' => $this->title,
            'payload' => $this->payload
        ];
        
        if ($this->imageURL != null) {
            $this->serializable['image_url'] = $this->imageURL;
        }
    }
}