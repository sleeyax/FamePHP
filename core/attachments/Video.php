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
 * Video attachment
 * @package Attachments
 */
class Video extends Attachment {
    /**
     * Video constructor.
     * @param      $attachmentLocation
     * @param null $attachmentName
     * @param bool $reusable
     */
    public function __construct($attachmentLocation, $attachmentName = null, $reusable = false) 
    {
        parent::__construct($attachmentLocation, $attachmentName, $reusable);
        $this->type = 'video';
    }
}
