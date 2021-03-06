<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/1/2018
 * Time: 10:57 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\Payment;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSync21Test
 * @package Magento\Webpos\Test\TestCase\Sync\Payment
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 * 2. Login backend on another browser  > Webpos setting > Select any method in Default Payment Method field
 * 3. Back to  the browser which are opening webpos
 *
 * Steps
 * 1. Go to synchronization page
 * 2. Update payment
 *
 * Acceptance Criteria
 * 2. The payment method just selected on setting page will be updated and display on webpos checkout page as default payment method
 */
class WebposSync21Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * @var AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    public function __prepare()
    {
        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method_all_method']
        )->run();
    }

    /**
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     * @param AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    public function __inject(
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible,
        AssertItemUpdateSuccess $assertItemUpdateSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
    }

    /**
     * @param $products
     * @param FixtureFactory $fixtureFactory
     * @param $configData
     * @param $amount
     */
    public function test($products, FixtureFactory $fixtureFactory, $configData, $amount)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();
        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowUpdateButton("Payment")->click();
        sleep(5);

        $action = 'Update';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Payment", $action);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
        }
        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method']
        )->run();
    }
}
