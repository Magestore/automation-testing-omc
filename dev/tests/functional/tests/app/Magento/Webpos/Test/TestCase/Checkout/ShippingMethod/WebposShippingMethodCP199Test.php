<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 12/01/2018
 * Time: 16:38
 */

namespace Magento\Webpos\Test\TestCase\Checkout\ShippingMethod;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposShippingMethodCP199Test
 * @package Magento\Webpos\Test\TestCase\Cart\ShippingMethod
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Add a custom sale product with [Shippable] = No
 * 3. Click on [Checkout] button"
 *
 * Steps:
 * 1. Check shipping section
 *
 * Acceptance:
 * "1. Shipping section will be hidden
 * 2. Shipping field will be hidden on cart"
 *
 */
class WebposShippingMethodCP199Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($productCustom)
    {
        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        //Add product custom sale
        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productCustom['name']);
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($productCustom['price']);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        sleep(1);
        //Cart
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        return ['titleExpected' => null,
            'idSelected' => null,
            'panelExpected' => false];
    }
}