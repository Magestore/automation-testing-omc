<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/21/2018
 * Time: 8:29 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridGroupProductBlockAddToCartSuccessfullyPG43Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on the Group product block
 * 2. Increase [Qty] of a child product = 1
 * 3. Click on [Add to cart] button"
 *
 * Acceptance:
 * 3. The child product that updated Qty on step 2 will be added to cart successfully
 *
 */
class WebposProductGridGroupProductBlockAddToCartSuccessfullyPG43Test extends Injectable
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
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMainContent()->waitLoader();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getMainContent()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitForElementVisible("#popup-product-detail");
        // Select options
        $this->webposIndex->getCheckoutProductDetail()->fillGroupedProductQty($products[0]['product']);
        $childProducts = $products[0]['product']->getAssociated()['products'];
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('[id="popup-product-detail"]');
        $this->assertTrue(
            $this->webposIndex->getCheckoutCartItems()->getCartItem($childProducts[0]->getName())->isVisible(),
            "Product with name '" . $childProducts[0]->getName() . "' is not added to cart."
        );

    }
}