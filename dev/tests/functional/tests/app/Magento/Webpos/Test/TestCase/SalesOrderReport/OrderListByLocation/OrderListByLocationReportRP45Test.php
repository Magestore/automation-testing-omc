<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 2:14 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByLocation;

use DateTime;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByLocation;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Report
 * RP45-RP42 - Order list by location
 *
 * Precondition
 * Create some orders at some different locations
 *
 * Steps
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by location
 *
 * Acceptance
 * Orders just created will be updated and shown on corresponding location row
 *
 *
 * Class OrderListByLocationReportRP16Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByLocation
 */
class OrderListByLocationReportRP45Test extends Injectable
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
     * OrderListByLocation page.
     *
     * @var OrderListByLocation $orderListByLocation
     */
    protected $orderListByLocation;

    /*Open session required*/
    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes']
        )->run();
    }


    /**
     * Inject pages.
     *
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param OrderListByLocation $orderListLocation
     * @return void
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByLocation $orderListLocation
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByLocation = $orderListLocation;
    }

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     * @param $products
     * @param Pos $pos
     * @param Staff $staff
     * @param array $shifts
     * @param null $order_status
     */
    public function test(WebposIndex $webposIndex, FixtureFactory $fixtureFactory, $products, Pos $pos, Staff $staff, array $shifts, $order_status = null)
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

        $shifts['period_type'] = $location->getDisplayName();

        // Steps
        $this->webPOSAdminReportDashboard->open();
        $this->webPOSAdminReportDashboard->getLocationReport()->getPOSOrderListLocationIcon()->click();
        $this->orderListByLocation->getFilterBlock()->viewsReport($shifts);
        if ($order_status != null) {
            $order_status = array_map('trim', explode(',', $order_status));
            foreach ($order_status as $status) {
                $this->webPOSAdminReportDashboard->getReportDashboard()->setSalesReportOderStatuses($status);
                $this->orderListByLocation->getActionsBlock()->showReport();
                $this->webPOSAdminReportDashboard->getReportDashboard()->waitLoader();
            }
        } else {
            $this->orderListByLocation->getActionsBlock()->showReport();
        }
        if (isset($shifts['period_type'])) {
            $locationName = $this->webPOSAdminReportDashboard->getReportDashboard()->getLocationName()->getText();
            if ('We couldn\'t find any records.' != $locationName) {
                self::assertEquals(
                    $shifts['period_type'],
                    $locationName,
                    'In Admin Form Order List By Location WebPOS Page. The period type was not updated. It must be ' . $shifts['period_type']
                );
            }
        }
        if (isset($shifts['from']) && isset($shifts['to'])) {
            $fromDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportFormDate()->getValue();
            $toDate = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesReportToDate()->getValue();
            $fromDate = new DateTime($fromDate);
            $toDate = new DateTime($toDate);
            if (strpos($this->webPOSAdminReportDashboard->getReportDashboard()->getFirtRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
                $dateOfFirstRow = $this->webPOSAdminReportDashboard->getReportDashboard()->getFirstDateGrid();
                $dateOfFirstRow = new DateTime($dateOfFirstRow);
                self::assertTrue(
                    (int)$dateOfFirstRow->diff($fromDate)->format('%R%a') <= 0 &&
                    (int)$dateOfFirstRow->diff($toDate)->format("%R%a") >= 0
                );
            }
            if (strpos($this->webPOSAdminReportDashboard->getReportDashboard()->getLasRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
                $dateOfLastRow = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastDateGrid();
                $dateOfLastRow = new DateTime($dateOfLastRow);
                self::assertTrue(
                    (int)$dateOfLastRow->diff($fromDate)->format('%R%a') <= 0 &&
                    (int)$dateOfLastRow->diff($toDate)->format("%R%a") >= 0
                );
            }
        }
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