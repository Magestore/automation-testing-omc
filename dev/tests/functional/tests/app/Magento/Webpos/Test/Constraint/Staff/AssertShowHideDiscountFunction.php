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

class AssertShowHideDiscountFunction extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $tagDiscount)
    {
        if($tagDiscount=='hide')
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getCheckoutCartFooter()->getDiscount()->isVisible(),
                'Discount display but not hide'
            );
        if($tagDiscount=='show')
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getCheckoutCartFooter()->getDiscount()->isVisible(),
                'Discount display but not hide'
            );
    }



    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Show/hide discount is correct";
    }
}