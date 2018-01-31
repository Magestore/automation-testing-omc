<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/31/2018
 * Time: 1:25 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class AssertWebposOrdersHistoryInvoice
 * @package Magento\Webpos\Test\Constraint\OrderHistory\CheckGUI
 */
class AssertWebposOrdersHistoryInvoice extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param null $action
     */
    public function processAssert(WebposIndex $webposIndex, $action = null)
    {
        if ($action === 'CheckGUI'){
            if (!$webposIndex->getOrderHistoryInvoice()->isVisible()){
                $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
                $webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
            }
            sleep(1);
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getOrderHistoryInvoice()->isVisible(),
                'Invoice Popup is not visible.'
            );
        }elseif ($action === 'Popup-CheckGUI'){
            if (!$webposIndex->getOrderHistoryInvoice()->isVisible()){
                $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
                $webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
            }
            $webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
            sleep(1);
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getModal()->getOkButton()->isVisible(),
                'Button "OK" is not visible.'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getModal()->getCancelButton()->isVisible(),
                'Button "Cancel" is not visible.'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getModal()->getCloseButton()->isVisible(),
                'Button "Close" is not visible.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                'Are you sure you want to submit this invoice?',
                $webposIndex->getModal()->getPopupMessage(),
                'Notification is not correctly.'
            );
            $webposIndex->getModal()->getCancelButton()->click();
        }elseif ($action === 'Popup-Cancel' || $action === 'Popup-Close'){
            if (!$webposIndex->getOrderHistoryInvoice()->isVisible()){
                $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
                $webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
            }
            $webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
            sleep(1);
            if ($action === 'Popup-Cancel'){
                $webposIndex->getModal()->getCancelButton()->click();
            }elseif ($action === 'Popup-Close'){
                $webposIndex->getModal()->getCloseButton()->click();
            }
            sleep(1);
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getModal()->isVisible(),
                'Confirmation popup is not closed.'
            );
        }elseif ($action === 'Cancel'){
            if (!$webposIndex->getOrderHistoryInvoice()->isVisible()){
                $webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
                $webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
            }
            $webposIndex->getOrderHistoryInvoice()->getCancelButton()->click();
            sleep(1);
            \PHPUnit_Framework_Assert::assertFalse(
                $webposIndex->getOrderHistoryInvoice()->isVisible(),
                'Invoice Popup is not closed.'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Order History - Invoice was correctly.";
    }
}