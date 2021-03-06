<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\HoldOrder\AssertCheckOnHoldOrderEmpty;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH24Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\ProcessingOnHoldOrder
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Create an on-hold order successfully
 * 3. Add some products to cart
 * Steps:
 * 1. Go to On-hold order menu
 * 2. Click on [Checkout] button on the on-hold order
 * Acceptance Criteria:
 * The information of the on-hold order will be loaded to current cart that included some exist products
 */
class WebposOnHoldOrderONH24Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var AssertCheckOnHoldOrderEmpty $assertCheckEmpty
     */
    protected $assertCheckEmpty;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertCheckOnHoldOrderEmpty $assertCheckEmpty
     */
    public function __inject
    (
        WebposIndex $webposIndex,
        AssertCheckOnHoldOrderEmpty $assertCheckEmpty
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertCheckEmpty = $assertCheckEmpty;
    }

    /**
     * @param $products
     * @return array
     */
    public function test($products)
    {
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];
        $product3 = $products[2]['product'];

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

        //Assert empty order in on-hold-order
        $this->assertCheckEmpty->processAssert($this->webposIndex);

        //Back to checkout
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->checkout();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);

        //Add more product to cart
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($product3->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);

        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Cart in On-Hold
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);
        $this->webposIndex->getOnHoldOrderOrderList()->getFirstOrder()->click();
        $this->webposIndex->getOnHoldOrderOrderViewFooter()->getCheckOutButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = 1;
        $dataProduct2 = $product2->getData();
        $dataProduct2['qty'] = 1;
        $dataProduct3 = $product3->getData();
        $dataProduct3['qty'] = 1;
        return ['cartProducts' => [$dataProduct1, $dataProduct2, $dataProduct3]];
    }
}