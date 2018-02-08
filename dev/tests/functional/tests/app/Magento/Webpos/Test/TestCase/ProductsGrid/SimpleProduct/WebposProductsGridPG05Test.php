<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/7/2018
 * Time: 8:40 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\SimpleProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposProductsGridPG05Test extends Injectable
{
//    /**
//     * @var WebposIndex
//     */
//    protected $webposIndex;
//
//    public function __prepare()
//    {
//        // Config system value
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'default_backorders_configuration_use_system_value']
//        )->run();
//    }
//
//    public function __inject(
//        WebposIndex $webposIndex
//    )
//    {
//        $this->webposIndex = $webposIndex;
//    }

    public function test(
//        $products
    )
    {
        // Create products
//        $products = $this->objectManager->getInstance()->create(
//            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
//            ['products' => $products]
//        )->run();
//
//        // Config
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'no_backordes_no_still_allow_to_sync_order_from_WebPOS']
//        )->run();
//
//        // Login webpos
//        $staff = $this->objectManager->getInstance()->create(
//            'Magento\Webpos\Test\TestStep\LoginWebposStep'
//        )->run();

//        // Add product to cart
//        $this->objectManager->getInstance()->create(
//            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
//            ['products' => $products]
//        )->run();


        // BREAK BECAUSE TEST CASE IS WRONG

    }

//    /**
//     *
//     */
//    public function tearDown()
//    {
//        // Config system value
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'default_backorders_configuration_use_system_value']
//        )->run();
//    }
}