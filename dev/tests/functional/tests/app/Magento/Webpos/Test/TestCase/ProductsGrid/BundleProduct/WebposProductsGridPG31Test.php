<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/31/2018
 * Time: 3:43 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductWithSpecialPrice;

/**
 * Class WebposProductsGridPG31Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
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

        // Login webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();


        // Choose first product
        $this->webposIndex->getCheckoutProductDetail()->getRadioItemOfBundleProduct($products[0]['product']
            ->getBundleSelections()['products'][0][0]->getName())->click();
        sleep(1);
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