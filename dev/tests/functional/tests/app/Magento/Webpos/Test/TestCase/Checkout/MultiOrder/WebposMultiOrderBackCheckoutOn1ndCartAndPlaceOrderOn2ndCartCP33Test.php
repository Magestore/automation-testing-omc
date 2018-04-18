<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 13/12/2017
 * Time: 08:50
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;

/**
 * Class WebposMultiOrderBackCheckoutOn1ndCartAndPlaceOrderOn2ndCartCP33Test
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\MultiOrder
 */
class WebposMultiOrderBackCheckoutOn1ndCartAndPlaceOrderOn2ndCartCP33Test extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     * @return void
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
     * Login AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return void
     */
    public function test($products, FixtureFactory $fixtureFactory, $firstOrder, $secondOrder)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
//        Chuyển order number về 1 bên file data set
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($firstOrder)->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        //CategoryRepository On 1nd TaxClass. Add a product to 1nd cart
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $i++;
        }

        foreach ($products as $product) {
            $this->webposIndex->getCheckoutProductList()->search($product->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            break;
        }

        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Click On Icon Previous
        $this->webposIndex->getCheckoutWebposCart()->getIconPrevious()->click();
        sleep(2);
        $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($secondOrder)->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        //Add a product to 2nd cart
        foreach ($products as $product) {
            $this->webposIndex->getCheckoutProductList()->search($product->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            break;
        }

        $this->webposIndex->getCheckoutWebposCart()->getIconChangeCustomer()->click();
        $customerName = $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomerName()->getText();
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();

        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        return [
            'products' => $products];
    }
}