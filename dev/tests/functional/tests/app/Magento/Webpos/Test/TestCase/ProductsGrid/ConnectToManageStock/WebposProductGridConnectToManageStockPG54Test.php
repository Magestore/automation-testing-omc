<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/23/2018
 * Time: 9:14 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\ConnectToManageStock;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductGridConnectToManageStockPG54Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\ConnectToManageStock
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Go to manage stock page
 * 3. Edit any product in list (Qty=0, In stock: off)
 * 4. Update"
 *
 * Steps:
 * "1. Go to checkout page
 * 2. Add that product to cart"
 *
 * Acceptance:
 * "1. In grid: icon Out_stock display on that product image
 * 2.
 * - Can not add product to cart
 * - Display warning: this product is currently out of stock"
 *
 */
class  WebposProductGridConnectToManageStockPG54Test extends Injectable
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
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->manageStocks();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="manage_stock_container"]');

        /** wait first screen */
        while (!$this->webposIndex->getManageStockList()->getFirstProductRow()->isVisible()) {
            sleep(1);
        }

        $productName = $products[0]['product']->getName();
        $this->webposIndex->getManageStockList()->searchProduct($productName);

        /** wait until search done */
        while (!$this->webposIndex->getManageStockList()->getProductName($productName)->isVisible()) {
            sleep(1);
        }

        $this->webposIndex->getManageStockList()->setProductOutOfStock($productName);
        $this->webposIndex->getManageStockList()->getUpdateButton($productName)->click();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        $this->webposIndex->getCheckoutProductList()->search($productName);

        /** wait toast */
        while (!$this->webposIndex->getToaster()->isVisible()) {
            sleep(1);
        }

        $this->assertEquals(
            'This product is currently out of stock',
            $this->webposIndex->getToaster()->getWarningMessage()->getText(),
            'Warning message is wrong.'
        );

        $this->assertFalse(
            $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->isVisible(),
            'Out of stock product have been added to cart.'
        );

        $this->assertTrue(
            $this->webposIndex->getCheckoutProductList()->getFirstProductOutOfStockIcon()->isVisible(),
            'Out of stock icon is not visible.'
        );

    }
}