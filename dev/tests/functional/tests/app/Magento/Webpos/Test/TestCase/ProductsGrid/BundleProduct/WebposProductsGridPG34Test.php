<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/13/2018
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\BundleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG34Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on [View product details]
 * 2. Click on [Cancel] button"
 *
 * Acceptance:
 * "1. Show popup including:
 * - Action: Cancel
 * - Product image, SKU
 * - Description
 * - Product name
 * - Price of bundle product = SUM (price of selected child product)
 * - Child products of the bundle product with multi radio butons to choose, auto select first radio button
 * - [Quantity] textbox for each child product, default value = 1
 * - [Add to cart] button
 * 2. Close the popup"
 *
 */
class WebposProductsGridPG34Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
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
        $this->webposIndex->getCheckoutProductDetail()->waitForFormLoader();
        $this->webposIndex->getMainContent()->waitLoader();
        \PHPUnit_Framework_Assert::assertEquals(
            1,
            (int)$this->webposIndex->getCheckoutProductDetail()->getBundleFirstItemQty(),
            'Default qty was incorrect'
        );

        // Close popup
        if ($this->webposIndex->getCheckoutProductDetail()->isVisible()) {
            $this->webposIndex->getCheckoutProductDetail()->getButtonCancel()->click();
        }

        // Click detail product
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->getFirstProduct()->hover();
        $this->webposIndex->getCheckoutProductList()->getFirstProductDetailButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="popup-product-detail"]');
        sleep(1);

        return [
            'products' => $products,
            'checkDefault' => true
        ];
    }
}