<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 10:08 AM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomSaleCheckGUICP71EntityTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\DiscountProduct
 *
 * Preconditions:
 * 1. LoginTest webpos by a  staff
 *
 * Steps:
 * 1. Click on [Custom sale]
 *
 * Acceptance:
 * "Custom sale popup will be shown including:
 * - Fields: Product name, Product description, Price
 * - Select picker contents options: None,  goods
 * - Shippable: on, off
 * - Number table
 * - Button: Add to cart
 * - Action: Cancel"
 *
 */
class WebposCustomSaleCheckGUICP71EntityTest extends Injectable
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
     *
     * @return void
     */
    public function test()
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
    }
}