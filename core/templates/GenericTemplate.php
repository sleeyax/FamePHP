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
require_once 'Template.php';

/**
 * Class GenericTemplate
 * @package Templates
 */
class GenericTemplate extends Template {
    /**
     * Whether or not the generic template can be shared (in Messenger)
     *
     * @var boolean
     */
    private $isSharable = true;

    /**
     * Aspect ratio of image
     *
     * @var string horizontal | square
     */
    private $aspectRatio = 'horizontal';

    /**
     * Array of element objects that describe instances of the generic template to be sent
     * Max. 10 objects
     * Min. 0 objects
     *
     * @var array
     */
    protected $elements = array();

    /**
     * @var int max amount of elements allowed
     */
    protected $maxElementsCount = 10;

    /**
     * @var int min amount of elements allowed
     */
    protected $minElementsCount = 0;

    /**
     * Template type
     *
     * @var string
     */
    protected $type = 'generic';

    /**
     * GenericTemplate constructor.
     * @param      $elements
     * @param null $config
     */
    public function __construct($elements, $config = null)
    {
        if (count($elements) == count($elements, COUNT_RECURSIVE))
        {
            $this->constructElements($elements);
        }
        else
        {
            if (count($elements) > $this->maxElementsCount || count($elements) < $this->minElementsCount) {
                throw new \InvalidArgumentException("Amount of elements in template must be between $this->minElementsCount and $this->maxElementsCount");
            }
            
            foreach ($elements as $elementObj) {
                $this->constructElements($elementObj);
            }
        }

        $this->preparePayload();

        if ($config != null) {
            $this->updatePayload($config);
        }
    }

    /**
     * Adds each element obj to elements payload part
     *
     * @param array $element key:value pair array
     * @return void
     */
    protected function constructElements($element)
    {
        if (!isset($element['title']))
        {
            throw new \InvalidArgumentException('$title is required when using generic templates!');
        }

       $elementMap = [
            'title' => 'title',
            'subtitle' => 'subtitle',
            'image' => 'image_url',
            'onclick' => 'default_action',
            'buttons' => 'buttons'
        ];
        $object = [];

        foreach ($elementMap as $key => $value)
        {
            if (isset($element[$key])) {
                $object[$value] = (is_object($element[$key])) ? $element[$key]->GetJsonSerializable() : $element[$key];
            }   
        }

        $this->elements[] = $object;
    }

    /**
     * Prepare/build the payload for sending
     *
     * @return void
     */
    protected function preparePayload()
    {
        $this->payload['template_type'] = $this->type;
        $this->payload['sharable'] = $this->isSharable;
        $this->payload['image_aspect_ratio'] = $this->aspectRatio;
        $this->payload['elements'] = $this->elements;
    }

    /**
     * Overwrite template default properties
     *
     * @param array $config key=>value pair array
     * @return void
     */
    protected function updatePayload($config)
    {
        if (!is_array($config)) {
            throw new \InvalidArgumentException('$config must be a key=>value pair array!');
            
        }

        $validKeys = ['sharable', 'image_aspect_ratio'];

        foreach ($config as $key => $value) {
            if (!in_array($key, $validKeys)) {
                exit("Invalid key '$key' found in button config array!");
            }

            $this->payload[$key] = $value;
        }
    }
}

