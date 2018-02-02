<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 01/02/2018
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckDisplayNameCustomer extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex, $nameCustomer)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);

        //Check name customer display
        \PHPUnit_Framework_Assert::assertEquals(
            $nameCustomer,
            $webposIndex->getOnHoldOrderOrderList()->getFullNameCustomer()->getText(),
            'Name customer is not correct'
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
        return "Name customer is correct";
    }
}