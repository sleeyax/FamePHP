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

namespace Famephp\core\visuals;
require_once ROOTDIR . 'core/contracts/JsonSerializable.php';
use Famephp\core\contracts\JsonSerializable;

/**
 * Class QuickReply
 * @package Visuals
 */
class QuickReply implements JsonSerializable {

    /**
     * @var array json data
     */
    private $jsonSerializable;

    /**
     * Constructor
     *
     * @param object $preamble
     * @param ButtonList object $quickReplies
     */
    public function __construct($preamble, $quickRepliesButtonList)
    {
        if (!is_object($preamble)) {
            throw new \InvalidArgumentException('Failed to create QuickReply: $preamble must be an attachment or text object');
        }
        if (!is_object($quickRepliesButtonList)) {
            throw new \InvalidArgumentException('Failed to create QuickReply: $quickReplies must be a ButtonList of QuickReplyButtons');
        }
        
        $this->jsonSerializable = $preamble->GetJsonSerializable();
        $this->jsonSerializable['quick_replies'] = $quickRepliesButtonList->GetJsonSerializable();
    }

    /**
     * Get JSON serializable
     * @return array
     */
    public function getJsonSerializable()
    {
        return $this->jsonSerializable;
    }
}
?>
