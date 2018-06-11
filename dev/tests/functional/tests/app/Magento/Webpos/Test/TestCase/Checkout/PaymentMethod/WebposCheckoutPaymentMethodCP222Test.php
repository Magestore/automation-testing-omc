<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/18/2018
 * Time: 1:34 PM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\PaymentMethod;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckoutPaymentMethodCP222Test
 * @package Magento\Webpos\Test\TestCase\Checkout\PaymentMethod
 *
 * Precondition:
 * There are some payment methods on webpos
 * 1. Login Webpos as a staff
 * 2. Add some product to cart
 * 3. Click on [Checkout] button
 * 4. Select a shipping method"
 *
 * Steps:
 * 1. Select a payment method > fill amount greater than total order
 *
 * Acceptance:
 * "1. [Remain money] field  changes into [Expected change] with amount = [Entered amount] - [Total]
 * 2. [Create Invoice] field will be shown"
 *
 */
class WebposCheckoutPaymentMethodCP222Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    public function __prepare()
    {
        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method_all_method']
        )->run();
    }

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test($products, FixtureFactory $fixtureFactory, $configData, $amount)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
        }

        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

        $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);
        $am = $this->webposIndex->getCheckoutPlaceOrder()->getTopTotalPrice()->getText();
        $this->webposIndex->getCheckoutPaymentMethod()->getAmountPayment()->setValue(substr($am, 1) + $amount);
        $this->webposIndex->getCheckoutPaymentMethod()->getTitlePaymentMethod()->click();
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method']
        )->run();
    }
}