<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/02/2018
 * Time: 07:53
 */

namespace Magento\Webpos\Test\TestCase\Setting\Login;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Page\WebposIndex;

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
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var StaffEdit $staffEditPage
     */
    protected $staffEditPage;

    /**
     * AssertWebposCheckGUICustomerPriceCP54 Staff Index page.
     *
     * @var StaffIndex $staffsIndex
     */
    private $staffsIndex;

    /**
     * New Staff Group page.
     *
     * @var StaffNews $staffsNew
     */
    private $staffsNew;

    /**
     * @param WebposIndex $webposIndex
     * @param StaffIndex $staffsIndex
     * @param StaffNews $staffsNew
     * @param StaffEdit $staffEditPage
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
     * @param Staff $createStaff
     * @param $errorMessage
     */
    public function test(
        Staff $createStaff,
        $errorMessage
    )
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