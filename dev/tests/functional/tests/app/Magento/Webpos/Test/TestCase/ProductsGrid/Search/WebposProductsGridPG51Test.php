<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/23/2018
 * Time: 9:05 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\Search;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG51Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\Search
 *
 * Precondition:
 * "In backend:
 * 1. Go to Sales > Webpos > Settings > Product search:
 * [Product Attribute(s) for Search]: choose ""SKU"" and ""Product name""
 * On webpos:
 * 1. Login Webpos as a staff"
 *
 * Steps:
 * 1. Enter correct SKU or Product name on Search box
 * 2. Enter or click on Search icon
 *
 * Acceptance:
 * 2. Product grid shows the products have information matchs or contains keyword
 *
 */
class WebposProductsGridPG51Test extends Injectable
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
        // Config webpos product search by sku,product name
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_product_search_sku_product_name']
        )->run();

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

        $this->webposIndex->getCheckoutProductList()->search($products[0]['product']->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        return [
            'products' => $products
        ];
    }
}