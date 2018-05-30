<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 14:35
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomPrice;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomerPriceWithValidValueCP60Test
 * @package Magento\Webpos\Test\TestCase\CategoryRepository\CartPage\CustomPrice
 *
 * Precondition:
 * "1. Login webpos by a  staff
 * 2. Add a product to cart
 * 3. Click on the product on cart"
 *
 * Steps:
 * "1. Click on  [Custom price] tab
 * 2. Click on % option
 * 3. Input valid value to [Amount] field (type: %)
 * (Ex: 10)"
 *
 * Acceptance:
 * "Data on cart page is updated correspondingly:
 * + New price = (Old price x Amount)/100
 * + [Reg.] field is changeless"
 *
 */
class WebposCustomerPriceWithValidValueCP60Test extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex $webposIndex
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
     * @param CatalogProductSimple $product
     * @param $amountValue
     * @return array
     */
    public function test(CatalogProductSimple $product, $amountValue)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->search($product->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $price = $this->webposIndex->getCheckoutCartItems()->getValueItemPrice($product->getName());

        $this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();
        $this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getPercentButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($amountValue);
        //we need to set sleep($second) in this case.
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(1);
        return [
            'product' => $product,
            'price' => $price
        ];
    }
}