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
 * File attachment
 * @package Attachments
 */
class File extends Attachment {
    /**
     * File constructor.
     * @param      $attachmentLocation
     * @param null $attachmentName
     * @param bool $reusable
     */
    public function __construct($attachmentLocation, $attachmentName = null, $reusable = false) 
    {
        parent::__construct($attachmentLocation, $attachmentName, $reusable);
        $this->type = 'file';
    }
}
