<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/26/2018
 * Time: 9:27 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\Configuration;

use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSync09Test
 * @package Magento\Webpos\Test\TestCase\Sync\Configuration
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 * 2. Login backend on another browser > Webpos setting
 * 3. Change configuration of some fileds:
 * Ex: Web POS Color, Enable delivery date...
 * 4. Back to  the browser which are opening webpos
 *
 * Steps
 * 1. Go to synchronization page
 * 2. Reload configuration
 *
 * Acceptance Criteria
 * 2. The changes of config will be updated and shown on webpos page
 * - Webpos color is the color just changed
 * - Delivery date box will be shown on shipping method
 */
class WebposSync09Test extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    /**
     * New System Config Edit page.
     *
     * @var SystemConfigEdit $systemConfigEdit
     */
    private $systemConfigEdit;

    /**
     * @param SystemConfigEdit $systemConfigEdit
     * @param WebposIndex $webposIndex
     * @param AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    public function __inject(
        SystemConfigEdit $systemConfigEdit,
        WebposIndex $webposIndex,
        AssertItemUpdateSuccess $assertItemUpdateSuccess

    )
    {
        $this->systemConfigEdit = $systemConfigEdit;
        $this->webposIndex = $webposIndex;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;

    }

    /**
     * @param FixtureFactory $fixtureFactory
     * @param $configData
     */
    public function test(
        FixtureFactory $fixtureFactory,
        $configData
    )
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
        $this->webposIndex->getSyncTabData()->getItemRowReloadButton("Configuration")->click();
        sleep(5);
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Configuration", $action);
    }
}