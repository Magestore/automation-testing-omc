<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 10:28
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomPrice;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckGUICustomerPriceInsertNegativePriceCP55EntityTest
 * @package Magento\Webpos\Test\TestCase\CategoryRepository\CartPage\CustomPrice
 *
 * Precondition:
 * "1. Login webpos by a  staff
 * 2. Add a product to cart
 * 3. Click on the product on cart"
 *
 * Steps:
 * "1. Click on [Custom price] tab
 * 2. Input negative number to [Amount] field"
 *
 * Acceptance:
 * Nothing happens
 *
 */
class WebposCheckGUICustomerPriceInsertNegativePriceCP55EntityTest extends Injectable
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
     * @param $negativeValue
     * @return array
     */
    public function test(CatalogProductSimple $product, $negativeValue)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->search($product->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();
        $this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->click();
        $this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($negativeValue);
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(2);
        return [
            'product' => $product
        ];
    }
}