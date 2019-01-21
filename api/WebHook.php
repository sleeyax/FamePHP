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
require_once 'ConfigReader.php';

/**
 * Class WebHook
 * @package API
 */
class WebHook {

    /**
     * Verification token, see config
     * @var string
     */
    private $verificationToken;

    /**
     * WebHook constructor.
     *
     * @param $verificationToken
     */
    public function __construct($verificationToken)
    {
        $this->verificationToken = $verificationToken;
    }

    /**
     * Create a new webhook with facebook
     * @throws \InvalidArgsException
     */
    public function create()
    {
        if (isset($_GET['hub_challenge'])) {
            $challenge = $_GET['hub_challenge'];

            // If verification tokens match, return challenge (200 OK)
            if ($_GET['hub_verify_token'] === $this->verificationToken) {
                echo $challenge;
            }else{
                exit("Verification tokens do not match!");
            }
        }
    }

    /**
     * Read incoming (JSON) POST data from facebook
     *
     * @param bool $isJson
     * @return array json
     */
    public static function getIncomingData($isJson = true)
    {
       return $isJson ? json_decode(file_get_contents("php://input"), true) : file_get_contents("php://input");
    }
}