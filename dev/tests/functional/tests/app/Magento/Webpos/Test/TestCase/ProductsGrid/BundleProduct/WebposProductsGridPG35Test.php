<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/13/2018
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\ProductsGrid\BundleProduct\AssertChildProductOnProductDetail;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG35Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on [View product details]
 * 2. Select radio buttons that is different from default value
 * 3. Click on [Add to cart] button"
 *
 * Acceptance:
 * "2.
 * - Product price will be updated exactly
 * Product price = SUM (price of child products)
 * 3.
 * - That product will be added to cart successfully with Qty = 1
 * - The selected product attributes will be shown under the Product name on cart page"
 *
 */
class WebposProductsGridPG35Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertChildProductOnProductDetail $assertChildProductOnProductDetail
     */
    protected $assertChildProductOnProductDetail;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertChildProductOnProductDetail $assertChildProductOnProductDetail
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertChildProductOnProductDetail $assertChildProductOnProductDetail
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertChildProductOnProductDetail = $assertChildProductOnProductDetail;
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

        // Close popup
        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()) {
            $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
        }

        // Click detail product
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        $this->webposIndex->getCheckoutProductDetail()->getQtyOfOption(1)->setValue(2);

        // Assert
        $this->assertChildProductOnProductDetail->processAssert($this->webposIndex, $products);

        // Click add to cart
        $this->webposIndex->getCheckoutProductDetail()->getButtonAddToCart()->click();
        sleep(1);

        return [
            'products' => $products
        ];
    }
}