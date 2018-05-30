<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 15:27
 */

namespace Magento\Webpos\Test\TestCase\Checkout\ShippingMethod;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposShippingMethodCP195Test
 * @package Magento\Webpos\Test\TestCase\Checkout\ShippingMethod
 *
 * Precondition:
 * "In backend:
 * 1.  Go to webpos setting
 * 2. On [Shipping for POS] section:
 * [Applicable Shipping Methods] = ""All allowed shipping""
 * [Default Shipping Method]: Select a shipping method
 * 3. Click on [Save config] button
 * On webpos:
 * 1. Login Webpos as a staff
 * 2. Add some products  to cart
 * 3. Click on [Checkout] button"
 *
 * Steps:
 * 1. Check shipping section
 *
 * Acceptance:
 * "1. All of enable shipping methods will be shown on shipping section
 * 2. Default shipping method is the shipping method that selected on step 2 of [Precondtion and setup step] column
 * 3. Title of shipping method section: ""Shipping:[name of default shipping method]""
 * 4. Price of shipping method will be updated on cart"
 *
 */
class WebposShippingMethodCP195Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP195']
        )->run();
    }

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products)
    {

        //Create product
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run()[0]['product'];

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Add product to cart
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getShippingCollapse()->click();
        sleep(1);

        return ['titleExpected' => 'Shipping: Flat Rate - Fixed',
            'idSelected' => 'flatrate_flatrate',
            'panelExpected' => true];


    }
}