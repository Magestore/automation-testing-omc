<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/22/2018
 * Time: 3:35 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridCheckAddToCartOnGroupProductDetailPG47Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on [View product details]
 * 2. Increase [Qty] of all child product
 * 3. Click on [Add to cart] button
 * 4. Place order"
 *
 * Acceptance:
 * "3. All of the child products will be added to cart with corresponding to selected Qty
 * 4. Place order successfully"
 *
 */
class  WebposProductGridCheckAddToCartOnGroupProductDetailPG47Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param $products
     */
    public function test($products)
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

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        sleep(1);
        $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        // Select options
        $this->webposIndex->getCheckoutProductDetail()->fillGroupedProductQty($products[0]['product']);
        $childProducts = $products[0]['product']->getAssociated()['products'];
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        foreach ($childProducts as $childProduct) {
            $this->assertTrue(
                $this->webposIndex->getCheckoutCartItems()->getCartItem($childProduct->getName())->isVisible(),
                "Product with name '" . $childProduct->getName() . "' is not added to cart."
            );
        }
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