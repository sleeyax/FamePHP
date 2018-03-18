<?php
namespace Famephp\core\templates;
require_once 'Template.php';
use Famephp\core\templates\Template;

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
     * @var string horizontal|square
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
    protected $maxElementsCount = 10;
    protected $minElementsCount = 0;

    /**
     * Template type
     *
     * @var string
     */
    protected $type = 'generic';
    
    public function __construct($elements, $config = null)
    {
        if (!is_array($elements[0])) 
        {
            $this->ConstructElements($element);
        }
        else
        {
            if (count($elements) > $this->maxElementsCount || count($elements) < $this->minElementsCount) {
                throw new \InvalidArgumentException("Amount of elements in template must be between $this->minElementsCount and $this->maxElementsCount");
            }
            
            foreach ($elements as $elementObj) {
                $this->ConstructElements($elementObj);
            }
        }

        $this->PreparePayload();

        if ($config != null) {
            $this->UpdatePayload($config);
        }
    }

    /**
     * Adds each element obj to elements payload part
     *
     * @param array $element key:value pair array
     * @return void
     */
    protected function ConstructElements($element) 
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
    protected function PreparePayload() 
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
    protected function UpdatePayload($config) 
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
?>