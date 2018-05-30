<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 24/01/2018
 * Time: 22:21
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposHoldOrderCP173Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add a product to cart
 * 3. Hold order successfully"
 *
 * Steps:
 * "1. Go to [On-hold orders] menu
 * 2. Click on [Checkout] button on that detail order
 * 3. Back to cart page
 * 4. Click to Delete icon to clear cart"
 *
 * Acceptance:
 * "1. Cart page backs to default
 * 2. That hold order will be removed from On-hold orders list"
 *
 */
class WebposHoldOrderCP173Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products)
    {
        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
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

        //Click to Delete icon to clear cart
        $this->webposIndex->getCheckoutCartHeader()->getIconDeleteCart()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        return ['cartProducts' => null];

    }
}