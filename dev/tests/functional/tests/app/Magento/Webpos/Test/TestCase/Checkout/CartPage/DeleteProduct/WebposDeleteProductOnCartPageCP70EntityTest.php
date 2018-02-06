<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/11/2018
 * Time: 9:58 AM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteProduct;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;
/**
 *  * Preconditions:
 * 1. Login webpos by a  staff
 * 2. Add some product to cart
 *
 * Step:
 * 1. Click on [Checkout] button
 * 2. Back to cart page
 * 3. Click on delete product icon (x icon) of first product
 *
 */

/**
 * Class WebposDeleteProductOnCartPageCP70EntityTest
 * @package Magento\AutoTestWebposToaster\Test\TestCase\Checkout\CartPage\DeleteProduct
 */
class WebposDeleteProductOnCartPageCP70EntityTest extends Injectable
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
    public function test($products, FixtureFactory $fixtureFactory)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
            sleep(2);
        }
        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        sleep(2);
        $this->webposIndex->getCheckoutWebposCart()->getIconPrevious()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(2);
        $this->webposIndex->getCheckoutCartItems()->getIconDeleteItem()->click();
        sleep(2);
    }
}