<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/7/2018
 * Time: 9:37 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridCheckConfigProductBlockPG19Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\ConfigProduct
 */
class  WebposProductGridCheckAddToCartButtonOnConfigProductDetailPG26Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(WebposIndex $webposIndex)
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
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        sleep(3);         $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        sleep(3);
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();

        $this->assertTrue(
            $this->webposIndex->getModal()->isVisible(),
            'Error popup message is not showed.'
        );

        $this->assertEquals(
            'Please choose all options',
            $this->webposIndex->getModal()->getPopupMessage(),
            'Error popup message is wrong.'
        );
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getModal()->isVisible(),
            'Error popup is not hidden.'
        );
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);
        $this->webposIndex->getModal()->getCloseButton()->click();
        sleep(1);
        $this->assertFalse(
            $this->webposIndex->getModal()->isVisible(),
            'Error popup is not hidden.'
        );

    }
}