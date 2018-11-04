<?php
/**
 * FamePHP
 *
 * Facebook Messenger bot framework
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
 * Get bot-user info, goes hand in hand with Response class
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
        $this->config = ConfigReader::getInstance();
        $this->graph = new GraphRequest($this->config->read('page_access_token'));
    }

    /**
     * Get user message text
     *
     * @return mixed null | string
     * @throws \InvalidArgsException
     */
    public function GetMessageText()
    {
        $msg = WebHook::getIncomingData()['entry'][0]['messaging'][0]['message']['text'] ?? null;
        return $this->config->read('case_sensitive') == false ? strtolower($msg) : $msg;
    }

    /**
     * Get user message payload
     *
     * @param string $type type of payload to search for
     * @return mixed null | string payload
     */
    public function GetMessagePayload($type = 'quick_reply') 
    {
        return WebHook::getIncomingData()['entry'][0]['messaging'][0]['message'][$type]['payload'] ?? null;
    }

    /**
     * Get senderID of sent message
     *
     * @return mixed string | null
     */
    private function GetId() 
    {
       return WebHook::getIncomingData()['entry'][0]['messaging'][0]['sender']['id'] ?? null;
    }

    /**
     * Get all user infomation in an array
     *
     * @param bool $refreshInfo whether or not to re-fetch the info from facebook
     * @return array | null user data or null if user id is empty
     * @throws \InvalidArgsException
     * @example Accessible array keys of returned variable: first_name, last_name, profile_pic, id
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
                "?fields=first_name,last_name,profile_pic&access_token=" . $this->config->read('page_access_token')
            );
            $this->userInfo = json_decode($response, true);
            $this->graph->CloseSession();
        }

        // DEBUGGING
        /*if ($this->config->Read('debug') == true) {
            print_r($this->userInfo);
        }*/

        return $this->userInfo;
    }
}
?>