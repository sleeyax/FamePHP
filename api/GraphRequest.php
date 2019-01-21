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
namespace Famephp\api;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Famephp\api\loggers\ErrorLogger;

class GraphRequest
{
    /**
     * @var string
     */
    private $pageAccessToken;

    /**
     * @var Client
     */
    private $gc;

    /**
     * @var ErrorLogger
     */
    private $errorLogger;

    public function __construct(string $token)
    {
        $this->pageAccessToken = $token;
        $this->gc = new Client(['base_uri' => 'https://graph.facebook.com/v2.6/']);
        $this->errorLogger = new ErrorLogger();
    }

    /**
     * Fetch facebook user profile data
     *
     * @param string $userid
     * @return mixed
     */
    public function getUserProfile(string $userid)
    {
        $response = null;

        try {
            $response = $this->gc->request('GET', $userid, ['query' => [
                'fields' => implode(',', ['first_name', 'last_name', 'profile_pic']),
                'access_token' => $this->pageAccessToken
            ]])->getBody();
        }catch (GuzzleException $ex) {
            $this->errorLogger->log("Error while retrieving user profile. Exception caught: $ex");
        }

        return json_decode($response, true);
    }

    /**
     * Send remote (or Text) attachment
     *
     * @param $message
     * @return \Psr\Http\Message\StreamInterface
     */
    public function postMessage($message)
    {
        return $this->postPayload('messages', [
            'Headers' => [
                'Content-Type' => 'application/json'
            ],
            'form_params' => $message
        ]);
    }

    private function sendAttachment($attachment, $target = 'messages') {
        return $this->postPayload($target, [
            'Headers' => [
                'Content-Type' => 'multipart/form-data'
            ],
            'multipart' => $attachment
        ]);
    }

    /**
     * Post local attachment directly to user
     * @param $attachment
     * @return \Psr\Http\Message\StreamInterface
     */
    public function postAttachment($attachment)
    {
        return $this->sendAttachment($attachment, 'messages');
    }

    /**
     * Upload local attachment to facebook to be used later
     * @param $attachment
     * @return \Psr\Http\Message\StreamInterface
     */
    public function uploadAttachment($attachment)
    {
        return $this->sendAttachment($attachment, 'message_attachments');
    }

    /**
     * Post the final payload
     * @param string $section
     * @param array  $data
     * @return \Psr\Http\Message\StreamInterface
     */
    private function postPayload(string $section, array $data)
    {
        try {
            $response = $this->gc->request('POST', "me/$section?access_token=$this->pageAccessToken", $data);
            return $response->getBody();
        }catch (GuzzleException $ex) {
            exit($ex);
        }
    }
}
