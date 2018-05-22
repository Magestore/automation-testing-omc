<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/01/2018
 * Time: 12:22
 */
namespace Magento\Webpos\Test\Constraint\Staff;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertEditCustomPrice
 * @package Magento\Webpos\Test\Constraint\Staff
 */
class AssertEditCustomPrice extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $items
     */
    public function processAssert(WebposIndex $webposIndex, $items)
    {
        foreach ($items as $item)
        {
            $webposIndex->getCheckoutCartItems()->getCartItemByOrderTo($item)->click();
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getCheckoutProductEdit()->getDiscountButton()->isVisible(),
                'Discount display but not hide'
            );
            $webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
            sleep(2);
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Custom price is correct";
    }
}