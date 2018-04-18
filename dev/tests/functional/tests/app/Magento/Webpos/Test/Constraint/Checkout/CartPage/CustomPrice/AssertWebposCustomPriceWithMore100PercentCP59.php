<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 14:26
 */

namespace Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomPrice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertWebposCustomPriceWithMore100PercentCP59
 * @package Magento\Webpos\Test\Constraint\CategoryRepository\CartPage\CustomPrice
 */
class AssertWebposCustomPriceWithMore100PercentCP59 extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $amountValue)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            '100',
            $webposIndex->getCheckoutProductEdit()->getAmountInput()->getValue(),
            'The amount value is not automatically set to 100 percent when add value greater than 100.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'After set value to amount value greater than 100 percent. It\'ll be automatically set back to 100.' ;
    }
}