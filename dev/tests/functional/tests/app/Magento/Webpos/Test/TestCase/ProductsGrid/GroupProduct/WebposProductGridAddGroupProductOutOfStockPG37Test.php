<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 2/12/2018
 * Time: 2:49 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridAddGroupProductOutOfStockPG37Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\GroupProduct
 *
 * Precondition:
 * 1. Login webpos as a staff
 *
 * Steps:
 * "1. Click on the Group product block
 * 2. Click [Add to cart] a child item that out of stock "
 *
 * Acceptance:
 * "Display message: ""Warning: This product is
 * currently out of stock"""
 *
 */
class WebposProductGridAddGroupProductOutOfStockPG37Test extends Injectable
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

        // Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        foreach ($products as $item) {
            $this->webposIndex->getCheckoutProductList()->search($item['product']->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        }
        $errorMessage = $this->webposIndex->getToaster()->getWarningMessage()->getText();
        $this->assertEquals(
            'This product is currently out of stock',
            $errorMessage,
            'Warning message is wrong.'
        );

    }
}