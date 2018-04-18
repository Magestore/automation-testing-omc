<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/01/2018
 * Time: 12:22
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertCheckOnHoldSimpleProduct extends AbstractConstraint
{
    public function processAssert(WebposIndex $webposIndex,$products)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $webposIndex->getOnHoldOrderOrderList()->waitLoader();
        $webposIndex->getOnHoldOrderOrderList()->getFirstOrder();

        for ($i = 0; $i < count($products); ++$i)
        {
            \PHPUnit_Framework_Assert::assertEquals(
                $webposIndex->getOnHoldOrderOrderViewContent()->getNameProductOrderTo($i+1),
                $products[$i]['name'],
                'Name product is not correct'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $webposIndex->getOnHoldOrderOrderViewContent()->getPriceProductByOrderTo($i+1),
                floatval($products[$i]['price']),
                'Price product is not correct'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $webposIndex->getOnHoldOrderOrderViewContent()->getQtyProductByOrderTo($i+1),
                floatval($products[$i]['qty']),
                'Qty product is not correct'
            );
        }

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
        return "Product in On-hold-Order is correct";
    }
}