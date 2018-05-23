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
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Mange Session - Option to not send email on webpos sales
 * Testcase - Check displaying option send sale email on checkout page
 *
 * Precondition
 * Loged into backend
 * go to webpos settings page (path: On admin sidebar-> tap on Sales -> under webpos -> choose Setttings)
 *
 * Steps
 * 1. Set the field Ask for send sale order email before place order= No, after that click on btn Save config
 * 2. Login webpos with staff account
 * 3. Add any product to cart -> click btn checkout
 * 4. Observe all of options on checkout
 *
 * Acceptance
 * Not showing option sent sale email on checkout page
 *
 *
 * Class WebposManageSessionTC015
 * @package Magento\Webpos\Test\TestCase\SessionManagement\NewFeature
 */
class WebposManageSessionTC015Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    /**
     * Pos New page
     *
     * @var $posNews
     */
    private $posNews;


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
        $webposIndex->getCheckoutContainer()->waitForElementVisible('#webpos_cart');
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('#webpos_checkout');
        $webposIndex->getCheckoutPlaceOrder()->waitForElementVisible('.send-email-box');
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