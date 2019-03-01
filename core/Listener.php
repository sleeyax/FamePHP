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

use Famephp\api\WebHook;
use Famephp\api\ConfigReader;
use Famephp\core\Sender;
use Famephp\core\Response;

class Listener
{
    private $config;

    public function __construct()
    {
        $this->config = ConfigReader::getInstance();
    }

    /**
     * @param        $hiddenMessage
     * @param        $callback
     */
    public function hearsWhisper($hiddenMessage, $callback)
    {
        $this->hears($hiddenMessage, $callback, 'quick_reply');
    }

    /**
     * @param      $message
     * @param      $callback
     * @param null $payloadType array key to use for hidden message lookup
     */
    public function hears($message, $callback, $payloadType = null)
    {
        $data = WebHook::getIncomingData();

        if (empty($data)) {
            return;
        }
        $hearedMessage = $payloadType != null ? $data['entry'][0]['messaging'][0]['message'][$payloadType]['payload'] ?? null :
                        $data['entry'][0]['messaging'][0]['message']['text'] ?? null;
        $hearedMessage = $this->config->isCaseSensitive() ? $hearedMessage : strtolower($hearedMessage);

        if ($hearedMessage === $message) {
            $userid = $data['entry'][0]['messaging'][0]['sender']['id'];
            $sender = new Sender($userid);
            $response = new Response($sender->id);

            $callback($sender, $response);
        }
    }
}


