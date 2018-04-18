<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 10:35 AM
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
 * 1. Blank all fileds
 * 2. Click on [Add to cart] button
 *
 */
/**
 * Class WebposCustomSaleAddCustomSaleWithBlankFieldsCP72EntityTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale
 */

class WebposCustomSaleAddCustomSaleWithBlankFieldsCP72EntityTest extends Injectable
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
        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
    }
}