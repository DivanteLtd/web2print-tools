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


namespace Pimcore\Model\Document\Tag\Outputchanneltable\MetaEntry;

use \Pimcore\Model\Document\Tag\Outputchanneltable;


class Table extends Outputchanneltable\MetaEntry {

    /**
     * @var string
     */
    public $values;

    /**
     * @var string
     */
    public $spanCleanedValues;

    /**
     * @var bool
     */
    public $span;

    public function setConfig($config) {
        parent::setConfig($config);
        $this->setValues($config['values']);
    }

    public function setValues($values)
    {
        $this->values = $values;

        $index = 0;
        $this->spanCleanedValues = array();
        if($values) {
            foreach($values as $v) {
                for($i = 0; $i < $v['span']; $i++) {
                    $this->spanCleanedValues[] = $v['value'];
                }
            }

        }
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getValue($index)
    {
        return $this->spanCleanedValues[$index];
    }

    private $nextValue = -1;
    public function resetNextValue() {
        $this->nextValue = -1;
    }

    public function getNextSpanCleanedValue() {
        $this->nextValue++;
        return $this->spanCleanedValues[$this->nextValue];
    }

    public function getNextValue() {
        $this->nextValue++;
        return $this->values[$this->nextValue];
    }

    /**
     * @param boolean $span
     */
    public function setSpan($span)
    {
        $this->span = $span;
    }

    /**
     * @return boolean
     */
    public function getSpan()
    {
        return $this->span;
    }


    public function __toString()
    {
        return $this->getName() . ": " . $this->getValue(0);
    }

}