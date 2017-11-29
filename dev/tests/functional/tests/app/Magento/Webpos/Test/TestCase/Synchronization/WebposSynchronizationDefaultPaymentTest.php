<?php
/**
 * Created by: thomas
 * Date: 03/11/2017
 * Time: 23:16
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;

use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;

/**
 * Steps:
 *
 * 1. Login to backend.
 * 2. Go to Stores -> Configuration -> Magestore Extension -> WebPos.
 * 3. Set "default payment method" to Web POS - Cash In.
 *
 * @ZephyrId MAGETWO-46903
 */
class WebposSynchronizationDefaultPaymentTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * New System Config Edit page.
     *
     * @var SystemConfigEdit
     */
    private $systemConfigEdit;

    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    /**
     * Inject System Config Edit pages.
     * @param SystemConfigEdit $systemConfigEdit
     * @return void
     */
    public function __inject(
        SystemConfigEdit $systemConfigEdit,
        WebposIndex $webposIndex,
        AssertItemUpdateSuccess $assertItemUpdateSuccess
    ) {
        $this->systemConfigEdit = $systemConfigEdit;
        $this->webposIndex = $webposIndex;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
    }

    /**
     * Open backend system config and set configuration values.
     *
     * @param SystemConfigEdit $systemConfigEdit
     * @param ConfigData $dataConfig
     * @return void
     */
    public function test(SystemConfigEdit $systemConfigEdit, ConfigData $dataConfig, Staff $staff, $name, $products, $email)
    {
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(3);
        $this->webposIndex->getCheckoutPage()->clickFirstProduct();
        foreach ($products as $product) {
            $this->webposIndex->getCheckoutPage()->search($product);
        }
        sleep(2);
        $this->webposIndex->getCheckoutPage()->clickCheckoutButton();
        sleep(1);
        if ($this->webposIndex->getCheckoutPage()->getCreditCard()->isVisible()) {
            self::assertTrue(
                $this->webposIndex->getCheckoutPage()->getCreditCard()->isVisible(),
                'The Web POS - Cash In was selected so another method can not select.'
            );
            sleep(1);
            self::assertTrue(
                $this->webposIndex->getCheckoutPage()->getCashOnDelivery()->isVisible(),
                'The Web POS - Cash In was selected so another method can not select.'
            );
            $this->webposIndex->getCheckoutPage()->getCashIn()->click();
            sleep(1);
        }
        $this->webposIndex->getCheckoutPage()->clickPlaceOrder();
        $result = [];
        $result['notify-order-text'] = $this->webposIndex->getToaster()->getWarningMessage();
        sleep(1);
        $this->webposIndex->getCheckoutPage()->sendEmail($email);
        $result['send-email-success'] = $this->webposIndex->getToaster()->getWarningMessage();
        sleep(1);
        $result['order-id'] = $this->webposIndex->getCheckoutPage()->getOrderId();
        sleep(1);
        $this->webposIndex->getCheckoutPage()->clickNewOrderButton();
        sleep(2);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(2);
        $this->webposIndex->getCMenu()->synchronization();
        sleep(2);
        $this->webposIndex->getSynchronization()->getConfigurationUpdateButton()->click();

        // Assert category reload success
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, $name);

        //Set up general configuration in backend
        sleep(5);
        $systemConfigEdit->open();
        $section = $dataConfig->getSection();
        $keys = array_keys($section);
        foreach ($keys as $key) {
            $parts = explode('/', $key, 3);
            $tabName = $parts[0];
            $groupName = $parts[1];
            $fieldName = $parts[2];
            $systemConfigEdit->getForm()->getGroup($tabName, $groupName)
                ->setValue($tabName, $groupName, $fieldName, $section[$key]['label']);
        }
        $this->systemConfigEdit->getPageActions()->save();

        sleep(3);
        $this->webposIndex->open();
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->fill($staff);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            sleep(5);
            while ($this->webposIndex->getFirstScreen()->isVisible()) {
            }
            sleep(2);
        }
        sleep(2);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(2);
        $this->webposIndex->getCMenu()->synchronization();
        sleep(2);
        $this->webposIndex->getSynchronization()->getConfigurationUpdateButton()->click();
        // Assert category reload success
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, $name);

        //Checkout again
        sleep(5);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(2);
        $this->webposIndex->getCMenu()->checkout();
        sleep(3);
        $this->webposIndex->getCheckoutPage()->clickFirstProduct();
        sleep(1);
        foreach ($products as $product) {
            $this->webposIndex->getCheckoutPage()->search($product);
            sleep(1);
        }
        sleep(2);
        $this->webposIndex->getCheckoutPage()->clickCheckoutButton();
        sleep(1);

        if (!($this->webposIndex->getCheckoutPage()->getCreditCard()->isVisible())) {
            self::assertFalse(
                $this->webposIndex->getCheckoutPage()->getCreditCard()->isVisible(),
                'The Web POS - Cash In was selected so another method can not select.'
            );
            sleep(1);
            self::assertFalse(
                $this->webposIndex->getCheckoutPage()->getCashOnDelivery()->isVisible(),
                'The Web POS - Cash In was selected so another method can not select.'
            );
        } else {
            $this->webposIndex->getCheckoutPage()->getCashIn()->click();
        }
        sleep(1);
        $this->webposIndex->getCheckoutPage()->clickPlaceOrder();
        $result = [];
        $result['notify-order-text'] = $this->webposIndex->getToaster()->getWarningMessage();
        sleep(1);
        $this->webposIndex->getCheckoutPage()->sendEmail($email);
        $result['send-email-success'] = $this->webposIndex->getToaster()->getWarningMessage();
        sleep(1);
        $result['order-id'] = $this->webposIndex->getCheckoutPage()->getOrderId();
        sleep(1);
        $this->webposIndex->getCheckoutPage()->clickNewOrderButton();
        return ['result' => $result];
    }
}