<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/31/2018
 * Time: 3:43 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductWithSpecialPrice;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG31Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 *
 * Precondition:
 * "In backend:
 * 1. Go to detail page of child item of the bundle product, setting
 * [Special price] is different [Price]
 * On webpos:
 * 1. Login webpos as a staff"
 *
 * Steps:
 * "1. Click on the bundle product
 * 2. Select the child item that has special price
 * 3. Add that child item to cart > place order"
 *
 * Acceptance:
 * "2. Show special price for that child item.
 * 3. Place order successfully with special price"
 *
 */
class WebposProductsGridPG31Test extends Injectable
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


        // Choose first product
        sleep(5);
        $this->webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($products[0]['product']
            ->getBundleSelections()['products'][0][0]->getName())->click();
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
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