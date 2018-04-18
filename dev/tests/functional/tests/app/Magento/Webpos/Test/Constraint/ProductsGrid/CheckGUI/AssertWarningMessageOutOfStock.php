<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/12/2018
 * Time: 2:42 PM
 */

namespace Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWarningMessageOutOfStock
 * @package Magento\Webpos\Test\Constraint\ProductsGrid\CheckGUI
 */
class AssertWarningMessageOutOfStock extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'This product is currently out of stock',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Warning message's Content is Wrong"
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Message is correctly.';
    }
}