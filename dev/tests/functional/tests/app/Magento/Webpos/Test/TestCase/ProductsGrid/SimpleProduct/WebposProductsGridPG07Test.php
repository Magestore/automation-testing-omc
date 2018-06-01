<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/9/2018
 * Time: 2:43 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductQtyInProductList;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG07Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 *
 * Precondition:
 * "In backend, setting:
 * 1. On product detail page, Setting [ Backorders] = ""Allow Qty Below 0 and Notify Customer""
 * - Edit [Available Qty] = 1
 * On webpos:
 * 1. Login webpos as a staff"
 *
 * Steps:
 * "1. Check the product that configurated in [Precondition and setup steps] column
 * 2. Add that product to cart with qty = 2
 * 3. Place order successfully"
 *
 * Acceptance:
 * "2. Add product successfully
 * 3. Qty on that product block is ""-1"""
 *
 */
class WebposProductsGridPG07Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertProductQtyInProductList
     */
    protected $assertProductQtyInProductList;

    /**
     *
     */
    public function __prepare()
    {
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_backorders_configuration_use_system_value']
        )->run();
    }

    /**
     * @param WebposIndex $webposIndex
     * @param AssertProductQtyInProductList $assertProductQtyInProductList
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertProductQtyInProductList $assertProductQtyInProductList
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertProductQtyInProductList = $assertProductQtyInProductList;
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

        // Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'backorders_allow_qty_below_0_and_notify_customer']
        )->run();

        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();


        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        // Add products to cart
        $this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        for ($i = 0; $i < 2; $i++) {
            $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
        }
        $availableQty = 1;

        // Assert available qty on page
        $this->assertProductQtyInProductList->processAssert($this->webposIndex, $availableQty);

        // Check out and Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Placer Order

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $availableQty = -1;

        // Assert available qty on page
        $this->assertProductQtyInProductList->processAssert($this->webposIndex, $availableQty);

        return [
            'products' => $products
        ];
    }

    /**
     *
     */
    public function tearDown()
    {
        // Config system value
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_backorders_configuration_use_system_value']
        )->run();
    }
}