<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/25/2017
 * Time: 12:29 AM
 */

namespace Magento\Customercredit\Test\Constraint\CreditProduct;

use Magento\Catalog\Test\Page\Adminhtml\CatalogProductNew;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductNew;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertNewCreditProductPageAvailable extends AbstractConstraint
{
    public function processAssert(CreditProductNew $creditProductNew, $buttons = null)
    {
        $creditProductNew->getCreditProductForm()->waitForElementNotVisible('[data-role="spinner"]');
        \PHPUnit_Framework_Assert::assertTrue(
            $creditProductNew->getCreditProductForm()->storeCreditTypeIsVisible(),
            'Type of Store Credit Value is not visible.'
        );
        if ($buttons !== null) {
            $buttonArray = explode(",", $buttons);
            foreach ($buttonArray as $button) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $creditProductNew->getCreditProductFormPageAction()->actionButtonIsVisible(trim($button)),
                    'Action button ' . $button . ' is not available.'
                );
            }
        }
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'New credit product page is available.';
    }
}