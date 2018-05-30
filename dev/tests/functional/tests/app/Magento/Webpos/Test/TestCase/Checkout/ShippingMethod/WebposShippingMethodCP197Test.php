<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 16:06
 */

namespace Magento\Webpos\Test\TestCase\Checkout\ShippingMethod;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposShippingMethodCP197Test
 * @package Magento\Webpos\Test\TestCase\Checkout\ShippingMethod
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add some product to cart
 * 3. Click on [Checkout] button"
 *
 * Steps:
 * "1. Select a shipping method with fee >0
 * 2. Back to cart page"
 *
 * Acceptance:
 * Fee shipping will be shown on cart page and total amount will be updated too
 *
 */
class WebposShippingMethodCP197Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197']
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
        sleep(3);
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Choose PoS shipping method
        sleep(3);
        $this->webposIndex->getCheckoutShippingMethod()->clickPOSShipping();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        sleep(3);

        //BackToCart
        $this->webposIndex->getCheckoutWebposCart()->getIconPrevious()->click();
        sleep(3);

        return [
            'total' => $this->webposIndex->getCheckoutWebposCart()->getTotal(),
            'subtotal' => $this->webposIndex->getCheckoutWebposCart()->getSubtotal(),
            'tax' => $this->webposIndex->getCheckoutWebposCart()->getTax()
        ];
    }
}