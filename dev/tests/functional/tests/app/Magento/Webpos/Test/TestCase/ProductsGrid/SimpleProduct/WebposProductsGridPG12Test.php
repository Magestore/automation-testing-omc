<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 11:00 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductWithSpecialPrice;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG12Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 *
 * Precondition:
 * "In backend:
 * 1. Go to detail page of simple product, setting
 * [Special price] is different [Price]
 * On webpos:
 * 1. Login webpos as a staff"
 *
 * Steps:
 * "1. Check price of that product
 * 2. Add product to cart
 * 3. Place order "
 *
 * Acceptance:
 * "1. Show both of origin price and special price on webpos but origin price will be strickthrough
 * 2. The product price is the special price on cart
 * 3. Place order successfully with special price"
 *
 */
class WebposProductsGridPG12Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertProductWithSpecialPrice
     */
    protected $assertProductWithSpecialPrice;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertProductWithSpecialPrice $assertProductWithSpecialPrice
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertProductWithSpecialPrice $assertProductWithSpecialPrice
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertProductWithSpecialPrice = $assertProductWithSpecialPrice;
    }

    /**
     * @param $products
     * @return array
     */
    public function test(
        $products
    )
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();


        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Assert Price Of Product
        $this->assertProductWithSpecialPrice->processAssert($this->webposIndex, $products);
        // End Assert Price Of Product

        // Check out and Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Placer Order

        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();

        return [
            'products' => $products,
            'orderId' => $orderId
        ];
    }
}