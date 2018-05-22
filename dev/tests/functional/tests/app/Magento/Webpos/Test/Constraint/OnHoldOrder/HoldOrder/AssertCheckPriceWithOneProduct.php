<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 31/01/2018
 * Time: 20:41
 */
namespace Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class AssertCheckPriceWithOneProduct
 * @package Magento\Webpos\Test\Constraint\OnHoldOrder\HoldOrder
 */
class AssertCheckPriceWithOneProduct extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     * @param $product
     * @param $type
     * @param $priceCustom
     */
    public function processAssert(WebposIndex $webposIndex, $product, $type, $priceCustom)
    {
        $webposIndex->getMsWebpos()->clickCMenuButton();
        $webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $webposIndex->getOnHoldOrderOrderList()->waitLoader();
        $webposIndex->getOnHoldOrderOrderList()->getFirstOrder();

//        Check origin price
//        \PHPUnit_Framework_Assert::assertEquals(
//            floatval($product['price']),
//            $webposIndex->getOnHoldOrderOrderViewContent()->getOriginPriceProductByOrderTo(1),
//            'Origin price product is not correct'
//        );

        //Check price
        switch ($type)
        {
            case 'custom_$' :
                $price = floatval($priceCustom);
                break;
            case 'custom_%' :
                $price = floatval($product['price'])*floatval($priceCustom)/100;
                break;
            case 'discount_$' :
                $price = floatval($product['price']) - floatval($priceCustom);
                break;
            case 'discount_%' :
                $price = floatval($product['price']) - floatval($product['price'])*floatval($priceCustom)/100;
                break;
            default :
                $price = 0;
        }
        \PHPUnit_Framework_Assert::assertEquals(
            $price,
            floatval($webposIndex->getOnHoldOrderOrderViewContent()->getPriceProductByOrderTo(1)),
            'Price product is not correct'
        );

        //Check subtotal
        \PHPUnit_Framework_Assert::assertEquals(
            $price * floatval($product['qty']),
            floatval($webposIndex->getOnHoldOrderOrderViewContent()->getSubtotalProductByOrderTo(1)),
            'Subtotal is not correct'
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
        return "All price is correct";
    }
}