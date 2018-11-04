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
use Famephp\api\ConfigReader;
use Famephp\api\GraphRequest;

class Sender
{
    public $id;

    public $firstname;

    public $lastname;

    public $profilePicture;

    public function __construct($id)
    {
        $this->id = $id;
        $sender = $this->getProfile($id);
        $this->firstname = $sender['first_name'];
        $this->lastname = $sender['last_name'];
        $this->profilePicture = $sender['profile_pic'];
    }

    private function getProfile($id)
    {
        $token = (ConfigReader::getInstance())->pageAccessToken;
        $graph = new GraphRequest($token);
        $graph->OpenSession();
        $response = $graph->get(
            "https://graph.facebook.com/v2.6/$id?fields=first_name,last_name,profile_pic&access_token=$token"
        );
        $graph->CloseSession();

        return json_decode($response, true);
    }
}
