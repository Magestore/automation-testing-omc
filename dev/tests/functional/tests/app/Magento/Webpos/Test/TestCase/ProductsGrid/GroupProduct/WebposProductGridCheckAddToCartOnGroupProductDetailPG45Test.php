<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/22/2018
 * Time: 3:19 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridCheckAddToCartOnGroupProductDetailPG45Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on the Group product block
 * 2. Click on [Add to cart] button"
 *
 * Acceptance:
 * 2. Show message: "Please specify the quantity of product(s)" under [Qty] text box of each child product
 *
 */
class  WebposProductGridCheckAddToCartOnGroupProductDetailPG45Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(WebposIndex $webposIndex)
    {
        $this->webposIndex = $webposIndex;
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

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(2);
        $childProducts = $products[0]['product']->getAssociated()['products'];
        foreach ($childProducts as $childProduct) {
            $productName = $childProduct->getName();
            $this->assertTrue(
                $this->webposIndex->getCheckoutProductDetail()->getGroupProductItemQtyMessageError($productName)->isVisible(),
                "Qty message error of product '" . $productName . "' is not visible"
            );
        }

    }
}