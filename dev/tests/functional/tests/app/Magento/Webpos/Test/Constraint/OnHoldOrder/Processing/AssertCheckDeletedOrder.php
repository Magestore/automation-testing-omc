<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 25/01/2018
 * Time: 15:44
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\Processing;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckDeletedOrder extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $messageEmtpy, $orderId)
    {
        $webposIndex->getOnHoldOrderOrderList()->getSearchOrderInput()->setValue($orderId);
        sleep(1);

        //Enter or click on Search icon
        $webposIndex->getOnHoldOrderOrderList()->getIconSearch()->click();
        $webposIndex->getOnHoldOrderOrderList()->waitLoader();
        sleep(1);

        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->isPresent(),
            'List Order is not empty'
        );

        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getOnHoldOrderOrderViewContent()->isMessageEmptyDiplay(),
            'Content is not empty'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            $messageEmtpy,
            $webposIndex->getOnHoldOrderOrderViewContent()->getMessageEmptyDiplay(),
            'Message empty is not correct'
        );
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->checkout();
        sleep(1);

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "List Order is empty and Show message: 'You do not have any orders yet' on Order detail";
    }
}