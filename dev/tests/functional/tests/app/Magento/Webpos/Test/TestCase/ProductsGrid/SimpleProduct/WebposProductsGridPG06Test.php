<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/9/2018
 * Time: 2:43 PM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductQtyInProductList;

/**
 * Class WebposProductsGridPG06Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 */
class WebposProductsGridPG06Test extends Injectable
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
            ['configData' => 'backorders_allow_qty_below_0']
        )->run();

        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

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