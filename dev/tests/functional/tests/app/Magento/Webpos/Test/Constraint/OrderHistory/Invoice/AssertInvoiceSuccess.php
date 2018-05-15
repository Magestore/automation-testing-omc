<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/18/2018
 * Time: 1:44 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\Invoice;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertInvoiceSuccess
 * @package Magento\Webpos\Test\Constraint\SectionOrderHistory\Invoice
 */
class AssertInvoiceSuccess extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getModal()->getModalPopup()->isVisible(),
            'Confirm Popup is not closed'
        );
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOrderHistoryInvoice()->isVisible(),
            'Invoice Pop is not closed'
        );
        sleep(2);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'Success Message is not displayed'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'The invoice has been created successfully.',
            $webposIndex->getToaster()->getWarningMessage()->getText(),
            "Success message's Content is Wrong"
        );

        $webposIndex->getNotification()->getNotificationBell()->click();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getNotification()->getFirstNotification()->isVisible(),
            'Notification list is empty'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'The invoice has been created successfully.',
            $webposIndex->getNotification()->getFirstNotificationText(),
            'Notification Content is wrong'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Invoice - Submit Invoice: Success";
    }
}