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

namespace Famephp\core\buttons;
require_once 'Button.php';
use Famephp\core\buttons\Button;

/**
 * URLButton
 * @package Buttons
 */
class URLButton extends Button {
    /**
     * Button title
     *
     * @var string of max. 20 chars
     */
    private $title;

    /**
     * URL to navigate to when button tapped
     *
     * @var string must use https if $messengerExtensions is set to true
     */
    private $url;

    /**
     * Height ratio of webview
     *
     * @var string full | compact | tall
     */
    private $webviewHeightRatio = 'full';

    /**
     * Whether or not to use messenger extensions
     *
     * @var boolean
     */
    private $messengerExtensions = false;

    /**
     * URL to fall back to
     * Defaults to $url
     *
     * @var string
     */
    private $fallbackURL;

     /**
     *  Whether or not to disable share button of webview
     *
     * @var boolean
     */
    private $disableWebviewShareButton = false;

    /**
     * Constructor
     *
     * @param string $title
     * @param string $url
     * @param array $config (optional) array to overwrite optional properties of URLbutton
     * -> array('webview_height_ratio' = 'compact')
     * For more info, see: https://developers.facebook.com/docs/messenger-platform/reference/buttons/url
     */
    public function __construct($title, $url, $config = null) 
    {
        if (strlen($title) > 20) {
            throw new \InvalidArgumentException('Error: 20 character limit exceeded when creating button title!');
        }
        
        $this->type = 'web_url';
        $this->title = $title;
        $this->url = $url;
        $this->fallbackURL = $url;

        $this->BuildSerializable();

        if ($config != null) {
            $this->UpdateSerializable($config);
        }
    }

    /**
     * Builds the JSON serializable
     *
     * @return void
     */
    private function BuildSerializable() 
    {
        $this->serializable['type'] = $this->type;
        $this->serializable['url'] = $this->url;
        $this->serializable['webview_height_ratio'] = $this->webviewHeightRatio;
        $this->serializable['messenger_extensions'] = $this->messengerExtensions;

        if ($this->title != null) {
            $this->serializable['title'] = $this->title;
        }
        if ($this->messengerExtensions == true) {
            $this->serializable['fallback_url'] = $this->url;
        }
        if ($this->disableWebviewShareButton == true) {
            $this->serializable['webview_share_button'] = 'hide';
        }
    }

    /**
     * Overwrite URLbutton default properties
     *
     * @param array $config key=>value pair array
     * @return void
     */
    private function UpdateSerializable($config) 
    {
        $validKeys = ['webview_height_ratio', 'messenger_extensions', 'fallback_url', 'webview_share_button'];

        foreach ($config as $key => $value) {
            if (!in_array($key, $validKeys)) {
                exit("Invalid key '$key' found in button config array!");
            }

            $this->serializable[$key] = $value;
        }
    }

}
?>