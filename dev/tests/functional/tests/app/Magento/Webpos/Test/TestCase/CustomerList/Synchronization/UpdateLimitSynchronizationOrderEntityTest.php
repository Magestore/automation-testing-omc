<?php
/**
 * Created by: thomas
 * Date: 12/10/2017
 * Time: 14:16
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\CustomerList\Synchronization;

use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;

/**
 * Class CreateNewCustomerEntityTest
 * @package Magento\Webpos\Test\TestCase\CustomerList
 */
class UpdateLimitSynchronizationOrderEntityTest extends Injectable
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
     * Inject Webpos Login pages.
     * @param SystemConfigEdit $systemConfigEdit
     * @param WebposIndex $webposIndex
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
    public function test(SystemConfigEdit $systemConfigEdit, ConfigData $dataConfig, Staff $staff, $name)
    {
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
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();
        sleep(2);
        $this->webposIndex->getSynchronization()->getConfigurationUpdateButton()->click();
        // Assert category reload success
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, $name);
        sleep(2);
        \PHPUnit_Framework_Assert::assertTrue(
            $this->webposIndex->getSynchronization()->getUpdateConfigurationSuccess()->isVisible(),
            "Update Configuration Synchronization successfully"
        );
    }
}