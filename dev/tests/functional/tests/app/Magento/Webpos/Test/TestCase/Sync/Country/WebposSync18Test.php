<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/26/2018
 * Time: 9:27 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\Country;

use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSync18Test
 * @package Magento\Webpos\Test\TestCase\Sync\Country
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 * 2. Login backend on another browser  > Configuration > Country > Edit some fileds (ex: Allow Countries )
 * 3. Back to  the browser which are opening webpos
 *
 * Steps
 * 1. Go to synchronization page
 * 2. Reload country
 *
 * Acceptance Criteria
 * 2. Country field was updated on Add new address popup
 */
class WebposSync18Test extends Injectable
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
        $this->webposIndex->getMainContent()->waitLoader();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowReloadButton("Country")->click();
        sleep(5);
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Country", $action);
    }
}