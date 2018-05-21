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
 *  * Preconditions:
 * 1. LoginTest webpos by a  staff
 *
 * Step:
 * 1. Click on [Custom sale]
 *
 */
/**
 * Class WebposCustomSaleCheckGUICP71EntityTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\DiscountProduct
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