<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/17/2018
 * Time: 10:33 AM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\PaymentMethod;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckoutPaymentMethodCP204Test
 * @package Magento\Webpos\Test\TestCase\Checkout\PaymentMethod
 *
 * Precondition:
 * "In backend:
 * 1.  Go to webpos setting
 * 2. On [Payment for POS] section:
 * [Applicable Payment Methods] = ""Specific payments""
 * [Specific Payment Methods]: select 1 payment method
 * [Default Payment Method] = blank
 * 3. Click on [Save config] button
 * On webpos:
 * 1. Sync cofiguration
 * 2. Login Webpos as a staff
 * 3. Add some products  to cart
 * 4. Click on [Checkout] button"
 *
 * Steps:
 * 1. Check payment section
 *
 * Acceptance:
 * "1. Selected payment method will be shown on payment section
 * 2. [Add payment] button is enable"
 *
 */
class WebposCheckoutPaymentMethodCP204Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __prepare()
    {
        // Config: use system value for all field in Tax Config
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method']
        )->run();
    }

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
    public function test($products, FixtureFactory $fixtureFactory, $configData)
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
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
            sleep(1);
        }

        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();


        $this->webposIndex->getCheckoutPlaceOrder()->getButtonAddPayment()->click();
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'default_payment_method']
        )->run();
    }
}