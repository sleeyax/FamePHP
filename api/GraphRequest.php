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

    public function __construct(string $token)
    {
        $this->pageAccessToken = $token;
        $this->gc = new Client(['base_uri' => 'https://graph.facebook.com/v2.6/']);
    }

    /**
     * Fetch facebook user profile data
     *
     * @param string $userid
     * @return mixed
     */
    public function getUserProfile(string $userid)
    {
        try {
            $response = $this->gc->request('GET', $userid, ['query' => [
                'fields' => implode(',', ['first_name', 'last_name', 'profile_pic']),
                'access_token' => $this->pageAccessToken
            ]]);
        }catch (GuzzleException $ex) {
            exit($ex); //TODO: use monolog to log this error
        }

        return json_decode($response->getBody(), true);
    }

    public function postMessage() {}

    public function postAttachment() {}

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
