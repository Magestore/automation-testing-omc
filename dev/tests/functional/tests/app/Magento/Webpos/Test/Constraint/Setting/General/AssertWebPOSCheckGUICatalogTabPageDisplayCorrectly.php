<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 15:53
 */

namespace Magento\Webpos\Test\Constraint\Setting\General;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebPOSCheckGUICatalogTabPageDisplayCorrectly
 * @package Magento\Webpos\Test\Constraint\Setting\General
 */
class AssertWebPOSCheckGUICatalogTabPageDisplayCorrectly extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getGeneralSettingContentRight()->getDisplayOutOfStockSelection()->isVisible(),
            'On the Setting General Page - In the menu Catalog Tab Page. Display Out Of Stock Selection was visible correctly.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'On the Setting General Page. In the menu Catalog Page. Everything were visible correctly.';
    }
}