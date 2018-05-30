<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/10/2018
 * Time: 3:21 PM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DiscountProduct;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposInputValidValueToDiscountPercentCP66EntityTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\DiscountProduct
 *
 * Preconditions:
 * 1. LoginTest webpos by a  staff
 * 2. Add a product to cart
 * 3. Click on the product on cart
 *
 * Step:
 * 1. Click on  [Discount] tab
 * 2. Click on % option
 * 3. Input valid value to [Amount] field (type: %)
 * (Ex: 10)
 *
 * Acceptance:
 * "Data on cart page is updated correspondingly:
 * + New price = Old price - (Old price x Amount)/100
 * + [Reg.] field is changeless"
 *
 */
class WebposInputValidValueToDiscountPercentCP66EntityTest extends Injectable
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
    public function test(CatalogProductSimple $product, $amountValue)
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
        $this->webposIndex->getCheckoutProductEdit()->getPercentButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($amountValue);
        //we need to set sleep($second) in this case.
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(2);
        return [
            'product' => $product,
            'price' => $price
        ];
    }
}