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

namespace Famephp\core\templates;
require_once 'Template.php';

use Famephp\core\buttons\ButtonList;
use Famephp\core\templates\Template;

/**
 * Class OpenGraphTemplate
 * @package Templates
 */
class OpenGraphTemplate extends Template {

    /**
     * URL to the OpenGraph resource
     *
     * @var string
     */
    private $url;

    /**
     * Button list
     * Max. 3
     *
     * @var array
     */
    private $buttons;

    /**
     * Constructor
     *
     * @param string $url
     * @param ButtonList $buttons
     */
    public function __construct($url, $buttons) 
    {
        if (!preg_match('/http[s]{0,1}:\/\//', $url) || strlen($url) > 80) {
            throw new \InvalidArgumentException('$url must be a valid URL of max. 80 chars when using OpenGraphTemplate! (http[s]://<yoursite>)');
        }

        if (!is_object($buttons)) {
             throw new \InvalidArgumentException('$buttons must be a ButtonList object when using OpenGraphTemplate!');
        }else{
            if ($buttons->GetButtonCount() > 3) {
                throw new \InvalidArgumentException('max 3 $buttons allowed when using OpenGraphTemplate!');
            }
        }

        $this->type = 'open_graph';
        $this->url = $url;
        $this->buttons = $buttons->GetJsonSerializable();
    }

    /**
     * Get JSON serializable
     * @return array
     */
    public function GetJsonSerializable() 
    {
       return [
           'attachment' => [
               'type' => 'template',
               'payload' => [
                   'template_type' => $this->type,
                   'elements' => [
                       [
                           'url' => $this->url,
                           'buttons' => $this->buttons
                       ]
                   ]
               ]
           ] 
        ];
    }
}
?>