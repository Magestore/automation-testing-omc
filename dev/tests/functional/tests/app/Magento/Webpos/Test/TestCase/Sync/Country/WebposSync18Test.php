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
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
/**
 * Class WebposSync18Test
 * @package Magento\Webpos\Test\TestCase\Sync\Country
 */
class WebposSync18Test extends Injectable
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
     * @var
     */
    protected $webposIndex;

    protected $assertItemUpdateSuccess;


    public function __prepare(FixtureFactory $fixtureFactory)
    {
        //
    }

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
     *
     * @return void
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
        $this->webposIndex->getSyncTabData()->getItemRowReloadButton("Country")->click();
        sleep(5);
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Country", $action);
    }

    public function tearDown()
    {
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'default_payment_method']
//        )->run();
    }

}