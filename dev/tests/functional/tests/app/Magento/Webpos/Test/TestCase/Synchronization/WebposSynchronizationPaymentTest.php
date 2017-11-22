<?php
/**
 * Created by: thomas
 * Date: 03/11/2017
 * Time: 15:08
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;

use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Steps:
 *
 * 1. Login to backend.
 * 2. Go to Stores -> Configuration -> Magestore Extension -> WebPos.
 * 3. Set "Specific Payment Methods" to "Web POS - Cash On Delivery" And "Web POS - Cash In".
 *
 * @ZephyrId MAGETWO-46903
 */
class WebposSynchronizationPaymentTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var SystemConfigEdit
     */
    protected $systemConfigEdit;

    /**
     * Fixture Factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var AssertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    public function __inject(
        WebposIndex $webposIndex,
        SystemConfigEdit $systemConfigEdit,
        FixtureFactory $fixtureFactory,
        AssertItemUpdateSuccess $assertItemUpdateSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->systemConfigEdit = $systemConfigEdit;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
    }

    public function test(
        Staff $staff,
        $configDataDataset
    )
    {
        $this->webposIndex->open();
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->fill($staff);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            sleep(5);
            while ($this->webposIndex->getFirstScreen()->isVisible()) {
            }
            sleep(2);
        }

        // Test Case: SYNC22
        // Allow some countries
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configDataDataset]
        )->run();
        sleep(2);

        // Reload Configuration
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(2);
        $this->webposIndex->getCMenu()->synchronization();
        sleep(1);
        $itemText = "Configuration";
        $this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

        // Assert Country reload success
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);

        // Reload Configuration
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        $this->webposIndex->getCheckoutPage()->clickFirstProduct();
        sleep(2);
        $this->webposIndex->getCheckoutPage()->clickCheckoutButton();
        sleep(1);
        self::assertTrue(
            $this->webposIndex->getCheckoutPage()->getCreditCard()->isVisible(),
            'update failed'
        );
        self::assertTrue(
            $this->webposIndex->getCheckoutPage()->getCashIn()->isVisible(),
            'update failed'
        );
        self::assertTrue(
            $this->webposIndex->getCheckoutPage()->getCashOnDelivery()->isVisible(),
            'update failed'
        );
    }
}
