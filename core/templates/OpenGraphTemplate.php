<?php
namespace Famephp\core\templates;
require_once 'Template.php';
use Famephp\core\templates\Template;

class OpenGraphTemplate extends Template {

    /**
     * URL to the OpenGraph resource
     *
     * @var string
     */
    private $url;

    /**
     * Button list
     * Max. 3
     *
     * @var array
     */
    private $buttons;

    /**
     * Constructor
     *
     * @param string $url
     * @param array $buttons
     */
    public function __construct($url, $buttons) 
    {
        if (!preg_match('/http[s]{0,1}:\/\//', $url) || strlen($url) > 80) {
            throw new \InvalidArgumentException('$url must be a valid URL of max. 80 chars when using OpenGraphTemplate! (http[s]://<yoursite>)');
        }
        if (!is_object($buttons)) {
             throw new \InvalidArgumentException('$buttons must be a button object when using OpenGraphTemplate!');
        }else{
            if ($buttons->GetButtonCount() > 3) {
                throw new \InvalidArgumentException('max 3 $buttons allowed when using OpenGraphTemplate!');
            }
        }

        $this->type = 'open_graph';
        $this->url = $url;
        $this->buttons = $buttons->GetJsonSerializable();
    }

    public function GetJsonSerializable() 
    {
       return [
           'attachment' => [
               'type' => 'template',
               'payload' => [
                   'template_type' => $this->type,
                   'elements' => [
                       [
                           'url' => $this->url,
                           'buttons' => $this->buttons
                       ]
                   ]
               ]
           ] 
        ];
    }
}
?>