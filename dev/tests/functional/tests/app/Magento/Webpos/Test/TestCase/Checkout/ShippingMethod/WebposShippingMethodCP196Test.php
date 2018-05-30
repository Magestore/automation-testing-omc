<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 15:46
 */

namespace Magento\Webpos\Test\TestCase\Checkout\ShippingMethod;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposShippingMethodCP196Test
 * @package Magento\Webpos\Test\TestCase\Checkout\ShippingMethod
 *
 * Precondition:
 * There are some shipping methods on webpos
 * 1. Login Webpos as a staff
 * 2. Add some product to cart
 * 3. Click on [Checkout] button"
 *
 * Steps:
 * "1. Select a shipping method on shipping method section
 * 2. Select other shipping method"
 *
 * Acceptance:
 * "1. Title of section shipping method will be update according to new shipping method
 * 2. Price of shipping method will be updated on cart and total cart will be updated too"
 *
 */
class WebposShippingMethodCP196Test extends Injectable
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

        //Choose a shipping method
        sleep(3);
        $this->webposIndex->getCheckoutShippingMethod()->clickFlatRateFixedMethod();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getShippingCollapse()->click();
        sleep(1);
        $shippingMethodBefore = [$this->webposIndex->getCheckoutWebposCart()->getPriceShipping(), $this->webposIndex->getCheckoutPlaceOrder()->getTitleShippingSection()];

        //Choose another shipping method
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(2);
        $this->webposIndex->getCheckoutShippingMethod()->clickFreeShipping();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(1);
        $shippingMethodAfter = [$this->webposIndex->getCheckoutWebposCart()->getPriceShipping(), $this->webposIndex->getCheckoutPlaceOrder()->getTitleShippingSection()];

        return ['shippingMethodBefore' => $shippingMethodBefore,
            'shippingMethodAfter' => $shippingMethodAfter
        ];
    }
}