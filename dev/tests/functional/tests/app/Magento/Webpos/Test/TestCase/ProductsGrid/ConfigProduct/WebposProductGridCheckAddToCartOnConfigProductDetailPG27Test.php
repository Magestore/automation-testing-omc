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
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        sleep(1);
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

        /** wait load stock */
        while ( $this->webposIndex->getCheckoutProductDetail()->getAvailableQty() <= 0) {
            sleep(1);
        }

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