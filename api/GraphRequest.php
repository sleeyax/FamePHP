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

    public function postMessage($message)
    {
        return $this->postPayload($message, 'messages');
    }

    public function postAttachment($attachment)
    {
        $this->postPayload($attachment, 'message_attachments');
    }

    // TODO: make this method private, and use the methods above
    public function postPayload(array $payload, string $section)
    {
        try {
            $response = $this->gc->request('POST', "me/$section?access_token=$this->pageAccessToken", [
                'Headers' => [
                    'Content-Type' => 'application/json'
                ],
                'form_params' => $payload
            ]);

            return $response->getBody();
        }catch (GuzzleException $ex) {
            exit($ex);
        }
    }
}
