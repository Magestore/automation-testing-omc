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
 * Class WebposProductsGridPG32Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on the bundle product block
 * 2. Click on [Cancel] button"
 *
 * Acceptance:
 * "1. Show popup including:
 * - Action: Cancel
 * - Product name
 * - Price of bundle product = SUM (price of selected child product)
 * - Child products of the bundle product with multi radio butons to choose, auto select first radio button
 * - [Quantity] textbox for each child product, default value = 1
 * - [Add to cart] button
 * 2. Close the popup"
 *
 */
class WebposProductsGridPG32Test extends Injectable
{
    /**
     * @var WebposIndex
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
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        return [
            'products' => $products,
            'checkDefault' => true
        ];
    }
}