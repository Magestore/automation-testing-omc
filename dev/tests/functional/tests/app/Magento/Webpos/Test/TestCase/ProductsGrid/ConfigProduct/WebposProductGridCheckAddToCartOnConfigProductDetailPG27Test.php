<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/7/2018
 * Time: 9:37 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridCheckConfigProductBlockPG19Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct
 */
class  WebposProductGridCheckAddToCartOnConfigProductDetailPG27Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
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
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        sleep(3);
        // Select options
        $attributes = $products[0]['product']->getConfigurableAttributesData()['attributes_data'];
        foreach ($attributes as $attribute) {
            $option = $attribute['options']['option_key_0']['label'];
            if($option === ""){
                $option = $attribute['options']['option_key_0']['admin'];
            }
            $label = $attribute['label'];
            $this->webposIndex->getCheckoutProductDetail()->selectAttributes($label, $option);
        }
//        $this->webposIndex->getCheckoutProductDetail()->waitForAvailableQtyVisible();
//        $actualAvailableQty = $this->webposIndex->getCheckoutProductDetail()->getAvailableQty();
//        $availableQty = $products[0]['product']->getConfigurableAttributesData()['matrix']['attribute_key_0:option_key_0']['qty'];
//        $this->assertEquals(
//            $availableQty,
//            $actualAvailableQty,
//            'Available qty is wrong.'
//        );
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        $this->assertTrue(
            $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->isVisible(),
            'Add product to cart is not successful.'
        );
        $productOption = $products[0]['product']->getConfigurableAttributesData()['attributes_data']['attribute_key_0']['options']['option_key_0']['label'];
        $actualProductOption = $this->webposIndex->getCheckoutCartItems()->getFirstCartItemOption()->getText();
        $this->assertEquals(
            $productOption,
            $actualProductOption,
            'Selected product atribute is wrong.'
        );

    }
}