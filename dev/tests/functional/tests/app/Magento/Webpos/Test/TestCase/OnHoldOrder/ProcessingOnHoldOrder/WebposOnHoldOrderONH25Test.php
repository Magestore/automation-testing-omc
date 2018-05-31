<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\HoldOrder\AssertCheckCartSimpleProduct;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH25Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Create an on-hold order successfully
 * 3. Click to add multi order then focus on 1st
 * Steps:
 * 1. Go to On-hold order menu
 * 2. Click on [Checkout] button on the on-hold order
 * Acceptance Criteria:
 * The information of the on-hold order will be loaded to 1st cart, 2nd cart is changeless
 */
class WebposOnHoldOrderONH25Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var AssertCheckCartSimpleProduct $assertCheckCart
     */
    protected $assertCheckCart;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertCheckCartSimpleProduct $assertCheckCart
     */
    public function __inject
    (
        WebposIndex $webposIndex,
        AssertCheckCartSimpleProduct $assertCheckCart
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertCheckCart = $assertCheckCart;
    }

    /**
     * @param $products
     */
    public function test($products)
    {
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create a on-hold-order
        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Create multiorder
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('1')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart in On-Hold
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Click icon < (Back to cart)
        $this->webposIndex->getCheckoutCartHeader()->getIconBackToCart()->click();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(1);

        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = 1;
        $this->assertCheckCart->processAssert($this->webposIndex, [$dataProduct1]);
        sleep(1);

        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem('2')->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(5);
        $this->assertCheckCart->processAssert($this->webposIndex, null);

    }
}