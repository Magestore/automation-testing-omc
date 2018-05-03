<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 11:00 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\CatalogRule\Test\Fixture\CatalogRule;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\ProductsGrid\SimpleProduct\AssertProductWithCatalogPriceRule;

/**
 * Class WebposProductsGridPG13Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct
 */
class WebposProductsGridPG13Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var CatalogRule $catalogRule
     */
    protected $catalogRule;

    /**
     * @var AssertProductWithCatalogPriceRule
     */
    protected $assertProductWithCatalogPriceRule;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertProductWithCatalogPriceRule $assertProductWithCatalogPriceRule
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertProductWithCatalogPriceRule $assertProductWithCatalogPriceRule
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertProductWithCatalogPriceRule = $assertProductWithCatalogPriceRule;
    }

    /**
     * @param CatalogRule $catalogPriceRule
     * @param $products
     * @return array
     */
    public function test(
        CatalogRule $catalogPriceRule,
        $products
    )
    {
        // Precondition
        $catalogPriceRule->persist();
        $this->catalogRule = $catalogPriceRule;

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
        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Assert Product Price
        $this->assertProductWithCatalogPriceRule->processAssert($this->webposIndex, $products, $catalogPriceRule);

        // Check out and Place Order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // Placer Order

        $orderId = $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText();

        return [
            'products' => $products,
            'orderId' => $orderId
        ];
    }

    /**
     *
     */
    public function tearDown()
    {
        // Delete Catalog Rule
        $this->objectManager->create('Magento\Webpos\Test\Handler\CatalogRule\Curl')->persist($this->catalogRule);
    }
}