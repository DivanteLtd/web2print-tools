<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    EcommerceFramework
 * @copyright  Copyright (c) 2009-2016 pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */


namespace Pimcore\Model\Document\Tag;

use \Pimcore\Model\Document;

class Customareatable extends Document\Tag implements \Iterator {

    /**
     * @var array
     */
    public $elements = array();

    /**
     * @var array
     */
    public $elementIds = array();

     /**
     * @see Document_Tag_Interface::getType
     * @return string
     */
    public function getType() {
        return "customareatable";
    }

    /*
     *
     */
    public function setElements() {
        if(empty($this->elements)) {
            $this->elements = array();
            foreach ($this->elementIds as $elementId) {
                $el = \Pimcore\Model\Element\Service::getElementById($elementId["type"], $elementId["id"]);
                if($el instanceof \Pimcore\Model\Element\ElementInterface) {
                    $this->elements[] = $el;
                }
            }
        }
    }

    /**
     * @see \Pimcore\Model\Document\Tag\TagInterface::getData
     * @return \stdClass|void
     */
    public function getData() {
        $this->setElements();

        $data = array(
            'elements' =>  $this->elements
        );

        return $data;
    }

    /**
     * @return \stdClass|void
     */
    public function getDataForResource() {

        $data = array(
            'elements' =>  $this->elementIds
        );

        return $data;
    }

    /**
     * Converts the data so it's suitable for the editmode
     * @return mixed
     */
    public function getDataEditmode() {

        $this->setElements();
        $return = array();

        if (is_array($this->elements) && count($this->elements) > 0) {
            foreach ($this->elements as $element) {
                if ($element instanceof \Pimcore\Model\Object\Concrete) {
                    $return[] = array($element->getId(), $element->getFullPath(), "object", $element->getClassName());
                }
                else if ($element instanceof \Pimcore\Model\Object\AbstractObject) {
                    $return[] = array($element->getId(), $element->getFullPath(), "object", "folder");
                }
            }
        }

        $data = array(
            'elements' =>  $return
        );

        return $data;
    }

    /**
     * @see \Pimcore\Model\Document\Tag\TagInterface::frontend
     * @return void
     */
    public function frontend() {

        $this->setElements();
        $return = "";

        if (is_array($this->elements) && count($this->elements) > 0) {
            foreach ($this->elements as $element) {
                $return .= \Pimcore\Model\Element\Service::getElementType($element) . ": " . $element->getFullPath() . "<br />";
            }
        }

        return $return;
    }

    /**
     * @see \Pimcore\Model\Document\Tag\TagInterface::setDataFromResource
     * @param mixed $data
     * @return void
     */
    public function setDataFromResource($data) {
        if($data = \Pimcore\Tool\Serialize::unserialize($data)) {
            $this->setDataFromEditmode($data);
        }
    }

    /**
     * @see \Pimcore\Model\Document\Tag\TagInterface::setDataFromEditmode
     * @param mixed $data
     * @return void
     */
    public function setDataFromEditmode($data) {

        if(is_array($data['elements'])) {
            $this->elementIds = $data['elements'];
        }
    }

    /**
     * @return \Pimcore\Model\Element\ElementInterface[]
     */
    public function getElements() {
        $this->setElements();
        return $this->elements;
    }

    /**
     * @return boolean
     */
    public function isEmpty() {
        $this->setElements();
        return count($this->elements) > 0 ? false : true;
    }

    /**
     * @return array
     */
    public function resolveDependencies() {

        $this->setElements();
        $dependencies = array();

        if (is_array($this->elements) && count($this->elements) > 0) {
            foreach ($this->elements as $element) {
                if ($element instanceof \Pimcore\Model\Object\AbstractObject) {

                    $key = "object_" . $element->getId();

                    $dependencies[$key] = array(
                        "id" => $element->getId(),
                        "type" => "object"
                    );
                }
            }
        }

        return $dependencies;
    }

    public function getFromWebserviceImport($wsElement) {
        // currently unsupported
        return array();
    }


    /**
     * @return array
     */
    public function __sleep() {

        $finalVars = array();
        $parentVars = parent::__sleep();
        $blockedVars = array("elements");
        foreach ($parentVars as $key) {
            if (!in_array($key, $blockedVars)) {
                $finalVars[] = $key;
            }
        }

        return $finalVars;
    }

    /**
     *
     */
    public function load () {
        $this->setElements();
    }

    /**
     * Methods for Iterator
     */

    public function rewind() {
        $this->setElements();
        reset($this->elements);
    }

    public function current() {
        $this->setElements();
        $var = current($this->elements);
        return $var;
    }

    public function key() {
        $this->setElements();
        $var = key($this->elements);
        return $var;
    }

    public function next() {
        $this->setElements();
        $var = next($this->elements);
        return $var;
    }

    public function valid() {
        $this->setElements();
        $var = $this->current() !== false;
        return $var;
    }

}
