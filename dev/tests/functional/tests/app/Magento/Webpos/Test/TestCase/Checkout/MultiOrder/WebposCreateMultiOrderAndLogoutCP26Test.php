<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 11/12/2017
 * Time: 13:47
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffEdit;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCreateMultiOrderAndLogoutCP26Test
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\MultiOrder
 *
 * Precondition:
 * "1. Login webpos as a staff
 * 2. Create multi order
 * 3. Logout webpos"
 *
 * Steps:
 * 1. Login webpos by other staff
 *
 * Acceptance:
 * Don't show multi order which created on step 2 of [Precondition and setup steps] column
 *
 */
class WebposCreateMultiOrderAndLogoutCP26Test extends Injectable
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
     * @param Staff $createStaff
     */
    public function test(Staff $createStaff)
    {
        //Begin The first login webpos
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        //End The first login webpos
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->logout();
        $this->webposIndex->getMsWebpos()->waitForElementVisible('.modals-wrapper');
        $this->webposIndex->getModal()->getOkButton()->click();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader.loading-mask');
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
        $this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
        $time = time();
        $timeAfter = $time + 90;
        while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter) {
            $time = time();
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        //End Login webpos by the other staff
        for ($i = 1; $i <= 2; $i++) {
            self::assertFalse(
                $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->isVisible(),
                'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass, The multi order item ' . $i . ' were visible successfully.'
            );
        }
        // Begin delete new Staff on magento backend
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\DeleteStaffEntityStep',
            ['staff' => $createStaff]
        )->run();
        // End delete new Staff on magento backend
    }
}