<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/02/2018
 * Time: 07:53
 */

namespace Magento\Webpos\Test\TestCase\Setting\Login;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Config\Test\Fixture\ConfigData;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
/**
 * Class WebPOSLoginByInactiveAccountTest
 * @package Magento\Webpos\Test\TestCase\Setting\LoginTest
 */
class WebPOSLoginByInactiveAccountTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'CS';
    /* end tags */
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Staff Index page.
     *
     * @var StaffIndex
     */
    private $staffsIndex;
    /**
     * New Staff Group page.
     *
     * @var StaffNews
     */
    private $staffsNew;
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;
    /**
     * @var StaffEdit
     */
    protected $staffEditPage;

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param StaffIndex $staffsIndex
     * @param StaffNews $staffsNew
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex,
        StaffIndex $staffsIndex,
        StaffNews $staffsNew,
        StaffEdit $staffEditPage
    )
    {
        $this->webposIndex = $webposIndex;
        $this->staffsIndex = $staffsIndex;
        $this->staffsNew = $staffsNew;
        $this->staffEditPage = $staffEditPage;
    }

    /**
     * LoginTest AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @param Staff $staff
     * @param Staff ConfigData
     * @return void
     */
    public function test(Staff $createStaff, $errorMessage)
    {
        // Begin create new Staff on magento backend
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\CreateNewStaffStep',
            ['staff' => $createStaff]
        )->run();
        // End create new Staff on magento backend
        //Begin LoginTest webpos by the other staff
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->getUsernameField()->setValue($createStaff->getUsername());
        $this->webposIndex->getLoginForm()->getPasswordField()->setValue($createStaff->getPassword());
        $this->webposIndex->getLoginForm()->clickLoginButton();
        self::assertEquals(
            $errorMessage,
            $this->webposIndex->getToaster()->getWarningMessage()->getText(),
            'In the WebPOS LoginTest Page, We could not login with an inactive account.'
        );
    }
}