<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 16:09
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckout;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCreateCustomerWithIncorrectEmailCOC05
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckout
 */
class AssertCreateCustomerFillAlFieldsCOC06  extends AbstractConstraint
{

    public function processAssert($result, WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'The customer is saved successfully.',
            $result['success'],
            'At the Customer On Checkout Page that Customer was created successfully.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'At the Customer On Checkout Page that Customer Created Success Messages is visible.'
        );
    }

    /**
     * Text fail while saving message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'At the Customer On Checkout Page that Customer was created successfully.';
    }
}