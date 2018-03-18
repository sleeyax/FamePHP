<?php
/**
 * Class for user side stuff (user -> bot)
 */

namespace Famephp\core;
require_once ROOTDIR . 'api/WebHook.php';
require_once ROOTDIR . 'api/ConfigReader.php';
require_once ROOTDIR . 'api/GraphRequest.php';
use Famephp\api\WebHook;
use Famephp\api\ConfigReader;
use Famephp\api\GraphRequest;

class User {

    private $userInfo = array();
    private $config;

    public function __construct()
    {
        $this->config = ConfigReader::GetInstance();
        $this->graph = new GraphRequest($this->config->Read('page_access_token'));
    }

    /**
     * Get the user message text
     *
     * @return null|string
     * @throws \InvalidArgsException
     */
    public function GetMessageText()
    {
        $msg = WebHook::GetJSONPostData()['entry'][0]['messaging'][0]['message']['text'] ?? null;
        return $this->config->Read('case_sensitive') == false ? strtolower($msg) : $msg;
    }

    /**
     * Get the user message payload
     * Payloads are always case sensitive
     *
     * @param string $type of payload to search for
     * @return null|string payload
     */
    public function GetMessagePayload($type = 'quick_reply') 
    {
        return WebHook::GetJSONPostData()['entry'][0]['messaging'][0]['message'][$type]['payload'] ?? null;
    }

    /**
     * Get the unique ID of the user
     *
     * @return string|null
     */
    private function GetId() 
    {
       return WebHook::GetJSONPostData()['entry'][0]['messaging'][0]['sender']['id'] ?? null;
    }

    /**
     * Get user infomation in an array
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