<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 10:58
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomPrice;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckGUICustomerPriceTest
 * @package Magento\Webpos\Test\TestCase\CategoryRepository\CartPage\CustomPrice
 *
 * Precondition:
 * "1. Login webpos by a  staff
 * 2. Add a product to cart
 * 3. Click on the product on cart"
 *
 * Steps:
 * "1. Click on [Custom price] tab
 * 2. Input 0 to [Amount] field"
 *
 * Acceptance:
 * "Data on cart page is updated correspondingly
 * + New price product = 0
 * + [Reg.] field is changeless"
 *
 */
class WebposCheckGUICustomerPriceTest extends Injectable
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
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($amountValue);
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(1);
        return [
            'product' => $product,
            'price' => $price
        ];
    }
}