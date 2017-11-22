<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 15:44
 */

namespace Magento\Webpos\Test\Constraint\CustomerOnCheckout;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCreateCustomerWithIncorrectEmailCOC05
 * @package Magento\Webpos\Test\Constraint\CustomerOnCheckout
 */
class AssertCreateCustomerWithIncorrectEmailCOC05  extends AbstractConstraint
{

    public function processAssert($result, WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            'Please enter a valid email address (Ex: johndoe@domain.com).',
            $result['email-error'],
            'At the Customer On Checkout Page that Customer Email cannot be null'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getAddCustomerOnCheckout()->getEmailError()->isVisible(),
            'At the Customer On Checkout Page that Customer Email error is displaying.'
        );
    }

    /**
     * Text fail while saving message is displayed
     *
     * @return string
     */
    public function toString()
    {
        return 'At the Customer On Checkout Page, We cannot save the customer with any blank field.';
    }
}