<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 25/01/2018
 * Time: 15:44
 */
namespace Magento\Webpos\Test\Constraint\Checkout\HoldOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCheckOnHoldOrderEmpty
 * @package Magento\Webpos\Test\Constraint\Cart\HoldOrder
 */
class AssertCheckOnHoldOrderEmpty extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $webposIndex->getOnHoldOrderOrderList()->waitLoader();
        $webposIndex->getOnHoldOrderOrderList()->getFirstOrder();

        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->isPresent(),
            'List Order is not empty'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "List Order is empty";
    }
}