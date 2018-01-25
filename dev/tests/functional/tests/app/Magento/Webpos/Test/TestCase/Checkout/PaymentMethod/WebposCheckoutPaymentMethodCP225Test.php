<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/18/2018
 * Time: 1:23 PM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\PaymentMethod;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;

class WebposCheckoutPaymentMethodCP225Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var
     */

    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    protected $assertCheckoutPaymentMethodCP223;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __prepare()
    {
        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method_all_method']
        )->run();
    }

    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     *
     * @return void
     */
    public function test($products, FixtureFactory $fixtureFactory, $configData, $amount)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $i = 0;
        foreach ($products as $product) {
            if ($i < 3 ){
                $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
                $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
                $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
                $this->webposIndex->getMsWebpos()->waitCartLoader();
            }
            if ($i == 3) break;
            $i++;
        }

        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //select shipping
        $this->webposIndex->getCheckoutShippingMethod()->clickFlatRateFixedMethod();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //select payment
        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue($amount);

        $this->webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->click();
        $this->webposIndex->getCheckoutAddMorePayment()->getCashOnDeliveryMethod()->click();
//        $this->webposIndex->CheckoutCartHeader()->getIconBackToCart()->click();
//
//        $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
//        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
//        $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//
//
//        //CategoryRepository
//        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
//        $this->webposIndex->getMsWebpos()->waitCartLoader();
//        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // place order getCreateInvoiceCheckbox
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Assert Place Order Success
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method']
        )->run();
    }
}