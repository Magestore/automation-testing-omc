<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 8:40 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductQtyInProductList;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG05Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 *
 * Precondition:
 * "In backend, setting:
 * 1. On product detail page, Setting [ Backorders] = ""No backorders""
 * - Edit [Available Qty] = 1
 * On webpos:
 * 1. Login webpos as a staff"
 *
 * Steps:
 * "1. Check the product that configurated in [Precondition and setup steps] column
 * 2. Add that product to cart with qty = 2"
 *
 * Acceptance:
 * 2. Add product unsuccessfully and show message: "Warning: We don't have as many "[Product Name]" as you requested. The current in-stock qty is "[available qty]"
 *
 */
class WebposProductsGridPG05Test extends Injectable
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
            ['configData' => 'backorders_no_backordes']
        )->run();

        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();


        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        // Add products to cart
        $this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $qty = 1;

        // Assert available qty on page
        $this->assertProductQtyInProductList->processAssert($this->webposIndex, $qty);

        // Add products to cart
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

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