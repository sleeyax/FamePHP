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

namespace Famephp\core;
use Famephp\api\ConfigReader;
use Famephp\api\GraphRequest;

/**
 * Class Sender
 * Represents the user that interacts with our bot
 *
 * @package Core
 */
class Sender
{
    /**
     * Facebook user id
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $lastname;

    /**
     * URL to facebook profile picture
     * @var string
     */
    public $profilePicture;

    /**
     * Sender constructor.
     *
     * @param string $id facebook user id
     */
    public function __construct(string $id)
    {
        $token = (ConfigReader::getInstance())->getPageAccessToken();
        $graph = new GraphRequest($token);
        $sender = $graph->getUserProfile($id);

        $this->id = $id;
        $this->firstname = $sender['first_name'];
        $this->lastname = $sender['last_name'];
        $this->profilePicture = $sender['profile_pic'];
    }
}
