<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 2:31 PM
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
 * 1. Input into [Product name]
 * 2. Input invalid value to [Price] field (Ex: abc)
 * 3. Click on [Add to cart] button
 *
 */
/**
 * Class WebposCustomSaleInputInvalidToPriceCP75EntityTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale
 */
class WebposCustomSaleInputInvalidToPriceCP75EntityTest extends  Injectable
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
    public function test($productName, $price)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productName);
        // number field price keyboard
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($price);
        sleep(2);
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
    }
}