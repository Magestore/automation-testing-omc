<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/10/2018
 * Time: 2:32 PM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DiscountProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
/**
 *  * Preconditions:
 * 1. LoginTest webpos by a  staff
 * 2. Add a product to cart
 * 3. Edit Discount product (type:$)
 *
 * Step:
 * 1. Click on [Discount] tab
 * 2. Input valid value to [Amount] field (type: $)
 */
/**
 * Class WebposInputValidValueToDiscountDollarCP64EntityTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\DiscountProduct
 */
class WebposInputValidValueToDiscountDollarCP64EntityTest extends Injectable
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
     * LoginTest AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return void
     */
    public function test(CatalogProductSimple $product)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitSearch();
        $this->webposIndex->getCheckoutProductList()->search($product->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $price = $this->webposIndex->getCheckoutCartItems()->getValueItemPrice($product->getName());

        $this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();
        $this->webposIndex->getCheckoutProductEdit()->getDiscountButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($price-$price/2);
        //we need to set sleep($second) in this case.
        $this->webposIndex->getMainContent()->waitForMsWebpos();
        $this->webposIndex->getMsWebpos()->clickOutsidePopup();
        return [
            'product' => $product,
            'price' => $price
        ];
    }
}