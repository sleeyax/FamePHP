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

namespace Famephp\core\templates;
require_once 'GenericTemplate.php';
use Famephp\core\templates\GenericTemplate;

/**
 * Class ListTemplate
 * @package Templates
 */
class ListTemplate extends GenericTemplate {
    /**
     * Sets the format of the first list items
     *
     * @var string compact | large
     */
    private $topElementStyle = 'compact';

    /**
     * Button to display at the bottom of the list
     * Max. 1
     *
     * @var object button
     */
    private $button;

    /**
     * ListTemplate constructor.
     * @param      $elements
     * @param null $button
     * @param null $config
     */
    public function __construct($elements, $button = null, $config = null) {
        $this->type = 'list';
        $this->minElementsCount = 2;
        $this->maxElementsCount = 4;
        
        if ($button != null) 
        {
            if (!is_object($button)) {
                throw new \InvalidArgumentException('$button must be a button object!');
            }

            $this->button = $button->GetJsonSerializable();
        }

        parent::__construct($elements, $config);
    }

    /**
     * Prepare payload for sending
     */
    protected function PreparePayload() {
        $this->payload['template_type'] = $this->type;
        $this->payload['top_element_style'] = $this->topElementStyle;
        $this->payload['elements'] = $this->elements;

        if (isset($this->button)) {
            $this->payload['buttons'][] = $this->button;
        }
    }

    /**
     * Overwrite template default properties
     *
     * @param array $config key=>value pair array
     * @return void
     */
    protected function UpdatePayload($config) 
    {
        if (!is_array($config)) {
            throw new \InvalidArgumentException('$config must be a key=>value pair array!');
        }

        $validKeys = ['top_element_style'];

        foreach ($config as $key => $value) {
            if (!in_array($key, $validKeys)) {
                exit("Invalid key '$key' found in button config array!");
            }

            $this->payload[$key] = $value;
        }
    }
}
?>