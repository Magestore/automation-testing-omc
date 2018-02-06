<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/10/2018
 * Time: 4:23 PM
 */
namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteProduct;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
/**
 *  * Preconditions:
 * 1. Login webpos by a  staff
 * 2. Add a product to cart
 *
 * Step:
 * 1. Click on delete product icon (x icon)
 *
 */
/**
 * Class WebposDeleteProductOnCartPageCP68EntityTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\DiscountProduct
 */
class WebposDeleteProductOnCartPageCP68EntityTest extends  Injectable
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
     * Login AssertWebposCheckGUICustomerPriceCP54 group test.
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
        $this->webposIndex->getCheckoutCartItems()->getIconDeleteItem()->click();
//        sleep(1);
    }
}