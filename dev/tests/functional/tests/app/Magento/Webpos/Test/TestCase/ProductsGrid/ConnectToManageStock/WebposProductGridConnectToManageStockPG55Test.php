<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/23/2018
 * Time: 2:04 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\ConnectToManageStock;

use Magento\Mtf\Client\Locator;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

class  WebposProductGridConnectToManageStockPG55Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(
        WebposIndex $webposIndex
    ){
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
        $this->webposIndex->getManageStockList()->setProductInStock($productName);
        $this->webposIndex->getManageStockList()->getUpdateButton($productName)->click();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        $this->webposIndex->getCheckoutProductList()->search($productName);

        /** wait until search done */
        while ( $this->webposIndex->getCheckoutProductList()->getNumberOfProducts()->getText() != 1) {
            sleep(1);
        }

        $this->assertTrue(
            $this->webposIndex->getCheckoutCartItems()->getFirstCartItem()->isVisible(),
            'Product is not added to cart.'
        );
        $this->assertFalse(
            $this->webposIndex->getCheckoutCartItems()->getFirstCartItemQty()->isVisible(),
            'Product qty is wrong in cart.'
        );
        $this->assertFalse(
            $this->webposIndex->getCheckoutProductList()->getFirstProductOutOfStockIcon()->isVisible(),
            'Out of stock icon is visible.'
        );

    }
}