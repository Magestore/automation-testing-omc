<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/21/2018
 * Time: 8:29 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposProductGridGroupProductCheckSpecialPricePG40Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    }

    public function test($products)
    {
        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        // Select options
        $this->webposIndex->getCheckoutProductDetail()->fillGroupedProductQty($products[0]['product']);
        $childProducts = $products[0]['product']->getAssociated()['products'];
        $actualSpecialPrices = $this->webposIndex->getCheckoutProductDetail()->getGroupChildProductSpecialPrices();
        for ($i = 0; $i < count($childProducts); $i++) {
            $specialPrice = $childProducts[$i]->getSpecialPrice();
            $this->assertEquals(
                $specialPrice,
                $actualSpecialPrices[$i],
                "Special price of product '" . $childProducts[$i]->getName() . "' is wrong."
            );
        }
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        // Check out and Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\PlaceOrderSetShipAndCreateInvoiceSwitchStep',
            [
                'createInvoice' => true,
                'shipped' => true
            ]
        )->run();

        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Placer Order
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // End Place Order

        // Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
        //End Assert Place Order Success
    }
}