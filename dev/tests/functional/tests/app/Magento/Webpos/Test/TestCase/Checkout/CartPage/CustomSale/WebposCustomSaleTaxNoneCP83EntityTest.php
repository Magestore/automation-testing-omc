<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/12/2018
 * Time: 8:58 AM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\CustomSale\AssertWebposCustomSaleShippingMethodSectionHidden;
/**
 *  * Preconditions:
 * 1. LoginTest webpos by a  staff
 * 2. Add custom product to cart with tax: none
 *
 * Step:
 * 1. Add custom product to cart with Tax: None
 */

class WebposCustomSaleTaxNoneCP83EntityTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     * @param AssertWebposCustomSaleShippingMethodSectionHidden $assertWebposCustomSaleShippingMethodSectionHidden
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param $productName
     * @param $productDescription
     */
    public function test($productName, $price)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productName);
        // number field price keyboard
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($price);
//        $this->webposIndex->getCheckoutCustomSale()->getTaxClassItem($tax)->click();

        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        //CategoryRepository
    }
}