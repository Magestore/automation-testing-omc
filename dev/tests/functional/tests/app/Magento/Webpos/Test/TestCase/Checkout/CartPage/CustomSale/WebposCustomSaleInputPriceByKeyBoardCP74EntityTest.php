<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 2:22 PM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 *  * Preconditions:
 * 1. Login webpos by a  staff
 * 2. Click on [Custom sale]
 *
 * Step:
 * 1. Input into [Product name], [Product description]
 * 2. Input valid value to [Price] field by keyboard
 * 3. Click on [Add to cart] button
 *
 */
/**
 * Class WebposCustomSaleInputPriceByKeyBoardCP74EntityTest
 * @package Magento\AutoTestWebposToaster\Test\TestCase\Checkout\CartPage\CustomSale
 */

class WebposCustomSaleInputPriceByKeyBoardCP74EntityTest extends  Injectable
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
     * @param $productName
     * @param $productDescription
     */
    public function test($productName, $productDescription, $price)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productName);
        $this->webposIndex->getCheckoutCustomSale()->getDescriptionInput()->setValue($productDescription);
        // number field price keyboard

        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($price);
        sleep(2);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
    }
}