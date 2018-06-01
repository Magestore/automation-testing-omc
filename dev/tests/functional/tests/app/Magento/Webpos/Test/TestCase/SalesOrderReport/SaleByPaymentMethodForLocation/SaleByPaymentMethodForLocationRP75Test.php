<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/31/18
 * Time: 1:18 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\SaleByPaymentForLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class SaleByPaymentMethodForLocationRP75Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodForLocation
 * Precondition and setup steps
 * Create some orders at some different locations and use some payment methods to checkout or take payment
 *
 * Steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method for location
 *
 * Acceptance Criteria
 * Order Count and Total sale of current day will be updated for ech payment and each locations
 *
 */
class SaleByPaymentMethodForLocationRP75Test extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * WebPOSAdminReportDashboard page.
     *
     * @var WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     */
    protected $webPOSAdminReportDashboard;

    /**
     * SaleByPaymentForLocation page.
     *
     * @var SaleByPaymentForLocation $saleByPaymentForLocation
     */
    protected $saleByPaymentForLocation;

    /*Open session required*/
    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();
    }

    /**
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SaleByPaymentForLocation $saleByPaymentForLocation
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SaleByPaymentForLocation $saleByPaymentForLocation
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->saleByPaymentForLocation = $saleByPaymentForLocation;
    }

    /**
     * @param array $shifts
     * @param null $order_statuses
     */
    public function test(WebposIndex $webposIndex, FixtureFactory $fixtureFactory, $products, Pos $pos, Staff $staff, array $shifts, $order_statuses = null)
    {
        //Precondition
        $pos->persist();
        $staffData = $staff->getData();
        $staffData['location_id'] = $pos->getLocationId();
        $staffData['pos_ids'] = $pos->getPosId();
        $staffData['status'] = 'Enabled';
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        $location = $pos->getDataFieldConfig('location_id')['source']->getLocation();
        //Login
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'location' => $location,
                'pos' => $pos,
                'hasOpenSession' => true,
                'hasWaitOpenSessionPopup' => true
            ]
        )->run();
        sleep(1);
        if ($webposIndex->getOpenSessionPopup()->isVisible()) {
            $webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
        }
        $webposIndex->getMsWebpos()->waitForCMenuVisible();
        $webposIndex->getMsWebpos()->getCMenuButton()->click();
        sleep(1);
        $webposIndex->getCMenu()->checkout();
        $webposIndex->getMsWebpos()->waitCartLoader();
        $webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        // Steps
        $this->saleByPaymentForLocation->open();
        $this->saleByPaymentForLocation->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        $this->saleByPaymentForLocation->getFilterBlock()->viewsReport($shifts);
        $this->saleByPaymentForLocation->getActionsBlock()->showReport();
        self::assertEquals(
//            $location->getDisplayName(),
            $location->getDisplayName(),
            $this->webPOSAdminReportDashboard->getReportDashboard()->getLastLocationGrid(),
            'Location ' . $location->getDisplayName() . ' wasn\'t showed'
        );
        self::assertEquals(
            'Web POS - Cash In',
            $this->webPOSAdminReportDashboard->getReportDashboard()->getLastPaymentGrid(),
            'Location Web POS - Cash In wasn\'t showed'
        );
    }

    /*Close session*/
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no']
        )->run();
    }
}