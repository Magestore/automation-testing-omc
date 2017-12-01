<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/28/2017
 * Time: 3:23 PM
 */

namespace Magento\Customercredit\Test\Constraint;

use Magento\Customercredit\Test\Page\CustomercreditListProduct;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertStoreCreditListProductPageAvailable
 * @package Magento\Customercredit\Test\Constraint
 */
class AssertStoreCreditListProductPageAvailable extends AbstractConstraint
{
    /**
     * @param CustomercreditListProduct $customercreditListProduct
     * @param $pageTitle
     */
    public function processAssert(CustomercreditListProduct $customercreditListProduct, $pageTitle)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $pageTitle,
            $customercreditListProduct->getCustomerCreditListProductTitleBlock()->getTitle(),
            'Invalid page title is displayed.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Store credit list product page is available.';
    }
}