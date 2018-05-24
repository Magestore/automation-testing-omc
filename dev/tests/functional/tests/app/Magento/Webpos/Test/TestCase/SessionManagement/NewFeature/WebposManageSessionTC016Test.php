<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/21/18
 * Time: 4:08 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\NewFeature;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Option to not send email on webpos sales
 * Testcase - Check when the send sale email option is turned on
 *
 * Precondition
 * 1. In backend -> go to webpos settings page -> set the field: Ask for send sale order email before place order= Yes
 * 2. Loged into webpos
 *
 * Steps
 * 1. Add any product to cart
 * 2. Select the customer to checkout order -> click btn checkout
 * 3. On checkout page, choose shipping & payment method
 * 4. turn on send sale email option
 *
 * Acceptance
 * 4. Btn send sale email is highlighted
 *
 *
 * Class WebposManageSessionTC016
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposManageSessionTC016Test extends Injectable
{

    public function __inject()
    {
        //Preconditon
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes,config_send_confirm_order']
        )->run();

    }

    public function test(FixtureFactory $fixtureFactory, WebposIndex $webposIndex, $products)
    {
//        login
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposWithSelectLocationPosStep')->run();
        sleep(2);
        if ($webposIndex->getOpenSessionPopup()->isVisible()) {
            $webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $webposIndex->getSessionRegisterShift()->waitLoader();
        }
        if ($webposIndex->getSessionRegisterShift()->isVisible()) {
            $webposIndex->getMsWebpos()->getCMenuButton()->click();
            $webposIndex->getMsWebpos()->waitForCMenuLoader();
            $webposIndex->getCMenu()->checkout();
            $webposIndex->getCheckoutProductList()->waitProductListToLoad();
        }

        //Add Product
        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $webposIndex->getMsWebpos()->waitCartLoader();
            sleep(2);
            $i++;
        }

        $webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#webpos_checkout');
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#checkout-method');
        $webposIndex->getCheckoutPlaceOrder()->getPaymentByMethod('cashforpos')->click();
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#payment-method');
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getCheckoutPlaceOrder()->getEmailSwithBox()->isVisible(),
            'Email Config still was showed'
        );
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no,config_no_send_confirm_order']
        )->run();
    }

}