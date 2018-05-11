<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/7/2018
 * Time: 9:37 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Setup\Exception;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridCheckConfigProductBlockPG19Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct
 */
class  WebposProductGridCheckSpecialPricePG21Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

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
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');

        /** wait render */
        sleep(2);
        // Select options
        $attributes = $products[0]['product']->getConfigurableAttributesData()['attributes_data'];
        foreach ($attributes as $attribute) {
            $option = $attribute['options']['option_key_1']['label'];
            if($option === ""){
                $option = $attribute['options']['option_key_1']['admin'];
            }
            $label = $attribute['label'];
            $this->webposIndex->getCheckoutProductDetail()->selectAttributes($label, $option);
        }
        $this->webposIndex->getCheckoutProductDetail()->waitForAvailableQtyVisible();
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        $configurationsProduct = $products[0]['product']->getDataFieldConfig('configurable_attributes_data')['source']->getProducts();
        $specialPrice = $configurationsProduct['attribute_key_0:option_key_1']->getSpecialPrice();
        $actualPrice = substr($this->webposIndex->getCheckoutCartItems()->getProductPrice()->getText(), 1);
        $this->assertEquals(
            $specialPrice,
            $actualPrice,
            'Special price is wrong'
        );
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

        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(0);
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