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

namespace Famephp\core;
require_once ROOTDIR . 'api/WebHook.php';
require_once ROOTDIR . 'api/ConfigReader.php';
require_once ROOTDIR . 'api/GraphRequest.php';
use Famephp\api\WebHook;
use Famephp\api\ConfigReader;
use Famephp\api\GraphRequest;

/**
 * Get bot-user info, goes hand in hand with Message class
 * @package Core
 */
class User {

    /**
     * User info
     * @var array
     */
    private $userInfo = array();

    /**
     * Instance
     * @var ConfigReader
     */
    private $config;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->config = ConfigReader::GetInstance();
        $this->graph = new GraphRequest($this->config->Read('page_access_token'));
    }

    /**
     * Get user message text
     *
     * @return null | string
     * @throws \InvalidArgsException
     */
    public function GetMessageText()
    {
        $msg = WebHook::GetJSONPostData()['entry'][0]['messaging'][0]['message']['text'] ?? null;
        return $this->config->Read('case_sensitive') == false ? strtolower($msg) : $msg;
    }

    /**
     * Get user message payload
     * Payloads are always case sensitive
     *
     * @param string $type type of payload to search for
     * @return null | string payload
     */
    public function GetMessagePayload($type = 'quick_reply') 
    {
        return WebHook::GetJSONPostData()['entry'][0]['messaging'][0]['message'][$type]['payload'] ?? null;
    }

    /**
     * Get senderID of sent message
     *
     * @return string | null
     */
    private function GetId() 
    {
       return WebHook::GetJSONPostData()['entry'][0]['messaging'][0]['sender']['id'] ?? null;
    }

    /**
     * Get all user infomation in an array
     * Array keys: first_name, last_name, profile_pic, id
     *
     * @param bool $refreshInfo whether or not to re-fetch the info from facebook
     * @return array
     * @return null if $userId is empty
     * @throws \InvalidArgsException
     */
    public function GetInfo($refreshInfo = false)
    {
        if ($refreshInfo == true || empty($this->userInfo)) {
            $userId = $this->GetId();
            if ($userId == null) {
                return;
            }

            $this->graph->OpenSession();
            $response = $this->graph->get(
                "https://graph.facebook.com/v2.6/" . $userId . 
                "?fields=first_name,last_name,profile_pic&access_token=" . $this->config->Read('page_access_token')
            );
            $this->userInfo = json_decode($response, true);
            $this->graph->CloseSession();
        }

        // DEBUGGING
        /*if ($this->config->Read('DEBUG') == true) {
            print_r($this->userInfo);
        }*/

        return $this->userInfo;
    }
}
?>