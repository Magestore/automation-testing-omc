<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/1/2018
 * Time: 4:50 PM
 */

namespace Magento\Webpos\Test\Constraint\OrderHistory;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class AssertOrderSuccess
 * @package Magento\Webpos\Test\Constraint\OrderHistory
 */
class AssertOrderSuccess extends AbstractConstraint
{

    /**
     * @param WebposIndex $webposIndex
     * @param $orderId
     */
    public function processAssert(WebposIndex $webposIndex, $orderId)
    {
        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getToaster()->getWarningMessage()->isVisible(),
            'Success Message is not displayed'
        );

        $webposIndex->getNotification()->getNotificationBell()->click();
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getNotification()->getFirstNotification()->isVisible(),
            'Notification list is empty'
        );
        \PHPUnit_Framework_Assert::assertEquals(
            'Order has been created successfully '.$orderId,
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