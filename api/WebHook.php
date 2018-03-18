<?php
/**
 * Creates a new webhook with facebook's server
 */

namespace Famephp\api;

require_once 'ConfigReader.php';
use Famephp\api\ConfigReader;

class WebHook {

    /**
     * Object for retrieving configuration settings
     *
     * @var ConfigReader object
     */
    private $config;

    /**
     * WebHook constructor.
     * @param string $config path
     * @throws \InvalidArgsException
     * @throws error
     */
    public function __construct($config = "api/Config.php")
    {
        $this->config = ConfigReader::GetInstance();
        $this->config->Load($config);
    }

    /**
     * Create a new webhook with facebook
     * @throws \InvalidArgsException
     */
    public function CreateNewHook() 
    {
        if (isset($_GET['hub_challenge'])) {
            $challenge = $_GET['hub_challenge'];

            // If verification tokens match, return challenge (200 OK)
            if ($_GET['hub_verify_token'] === $this->config->Read('verification_token')) {
                echo $challenge;
            }else{
                exit("Verification tokens do not match!");
            }
        }
    }

    /**
     * Read incoming JSON POST data from facebook
     *
     * @return array json
     */
    public static function GetJSONPostData()
    {
       return json_decode(file_get_contents("php://input"), true);
    }
}
?>