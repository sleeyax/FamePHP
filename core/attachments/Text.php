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
require_once 'Attachment.php';

/**
 * Text attachment
 * @package Attachments
 */
class Text extends Attachment {
    /**
     * @var string text to send
     */
    private $text;

    /**
     * Text constructor.
     * @param $text
     */
    public function __construct($text) 
    {
        $this->text = $text;
    }

    /**
     * Returns null (text attachments have no name)
     * @return null
     */
    public function getName() { return null; }

    /**
     * Returns null (text attachments have no name)
     * @return bool
     */
    public function isLocalAttachment() { return false; }

    /**
     * Get text JSON serializable
     * @return array
     */
    public function getJsonSerializable()
    {
        return [ 'text' => $this->text ];
    }
}
