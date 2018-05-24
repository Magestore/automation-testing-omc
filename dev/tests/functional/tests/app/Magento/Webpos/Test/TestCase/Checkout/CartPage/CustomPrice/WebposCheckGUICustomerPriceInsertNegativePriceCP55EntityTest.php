<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 10:28
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomPrice;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
/**
 * Class WebposCheckGUICustomerPriceInsertNegativePriceCP55EntityTest
 * @package Magento\Webpos\Test\TestCase\CategoryRepository\CartPage\CustomPrice
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