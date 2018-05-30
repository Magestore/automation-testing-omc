<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 09:35
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomPrice;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AssertWebposCheckGUICustomerPriceCP54
 * @package Magento\Webpos\Test\TestCase\CategoryRepository\CartPage\CustomPrice
 *
 * Precondition:
 * "1. Login webpos by a  staff
 * 2. Add a product to cart
 * 3. Click on the product on cart"
 *
 * Steps:
 *  1. Click on [Custom price] tab
 *
 * Acceptance:
 * "Display [Amount] field:
 * - Value default = 0
 * - 2 options: $ and %
 * - Focus on $ option"
 *
 */
class WebposCheckGUICustomerPriceCP54EntityTest extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex
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
     * LoginTest AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return void
     */
    public function test(CatalogProductSimple $product)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->search($product->getSku());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();
        $this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->click();
    }
}