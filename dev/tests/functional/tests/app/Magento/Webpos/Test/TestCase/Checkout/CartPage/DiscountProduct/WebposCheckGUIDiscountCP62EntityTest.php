<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/9/2018
 * Time: 8:54 AM
 */
namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DiscountProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
/**
 *  * Preconditions:
 * 1. Login webpos by a  staff
 * 2. Add a product to cart
 * 3. Click on the product on cart
 *
 * Step:
 * 1. Click on [Discount] tab
 *
 */
/**
 * Class WebposCheckGUIDiscountCP62EntityTest
 * @package Magento\AutoTestWebposToaster\Test\TestCase\Checkout\CartPage\DiscountProduct
 */
class WebposCheckGUIDiscountCP62EntityTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return void
     */
    public function test(CatalogProductSimple $product)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->search($product->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();
        $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->click();
    }
}