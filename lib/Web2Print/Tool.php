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


namespace Web2Print;

class Tool {

    public static function getMaxGroupDepth($configArray, $level = 1) {

        $groupFound = false;
        foreach($configArray as $configElement) {
            if($configElement instanceof \Elements\OutputDataConfigToolkit\ConfigElement\Operator\Group) {
                if(!$groupFound) {
                    $level++;
                    $groupFound = true;
                }

                $subLevel = self::getMaxGroupDepth($configElement->getChilds(), $level);

                if($subLevel > $level) {
                    $level = $subLevel;
                }
            }

        }

        return $level;
    }
}
