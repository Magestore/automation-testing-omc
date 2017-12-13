<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 11/12/2017
 * Time: 14:55
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Config\Test\Fixture\ConfigData;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
/**
 * Class WebposCreateMultiOrderAndLogoutCP27Test
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\Checkout\MultiOrder
 */
class WebposCreateMultiOrderAndLogoutCP27Test extends Injectable
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
     * Login AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @param Staff $staff
     * @param Staff ConfigData
     * @return void
     */
    public function test(Staff $createStaff)
    {
        //Begin The first login webpos
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        //End The first login webpos
        sleep(1);
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->logout();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(2);
        // Begin create new Staff on magento backend
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\CreateNewStaffStep',
            ['staff' => $createStaff]
        )->run();
        // End create new Staff on magento backend
        //Begin Login webpos by the other staff
        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->getUsernameField()->setValue($createStaff->getUsername());
        $this->webposIndex->getLoginForm()->getPasswordField()->setValue($createStaff->getPassword());
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(2);
        //End Login webpos by the other staff
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->logout();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(2);
        //Begin The 3rd login webpos
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        //End The 3rd login webpos
        for ($i=1; $i<=2; $i++) {
            self::assertFalse(
                $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->isVisible(),
                'On the AssertWebposCheckGUICustomerPriceCP54 Cart, The multi order item '.$i.' were visible successfully.'
            );
        }
        // Begin delete new Staff on magento backend
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\DeleteStaffEntityTest',
            ['staff' => $createStaff]
        )->run();
        // End delete new Staff on magento backend
    }
}