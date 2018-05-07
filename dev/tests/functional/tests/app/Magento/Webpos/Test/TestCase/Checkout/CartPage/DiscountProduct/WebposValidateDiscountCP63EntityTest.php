<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/9/2018
 * Time: 11:02 AM
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
 * 2. Input integer number that greater than price product to [Amount] field (type: $)
 */
/**
 * Class WebposValidateDiscountCP63EntityTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\DiscountProduct
 */
class WebposValidateDiscountCP63EntityTest extends Injectable
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
        $price = $this->webposIndex->getCheckoutCartItems()->getValueItemPrice($product->getName());

        $this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();
        $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($price+10);
        //we need to set sleep($second) in this case.
        sleep(1);
        $this->webposIndex->getMainContent()->clickOutsidePopup();
        return [
            'product' => $product,
            'price' => $price
        ];
    }
}