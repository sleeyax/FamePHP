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

namespace Famephp\core\buttons\QuickReplies;
require_once ROOTDIR . 'core/buttons/Button.php';
use Famephp\core\buttons\Button;

/**
 * Class PhoneQuickReplyButton
 * @package QuickReplies
 */
class PhoneQuickReplyButton extends Button
{
    /**
     * PhoneQuickReplyButton constructor
     */
    public function __construct() { $this->serializable['content_type'] = 'user_phone_number'; }
}
