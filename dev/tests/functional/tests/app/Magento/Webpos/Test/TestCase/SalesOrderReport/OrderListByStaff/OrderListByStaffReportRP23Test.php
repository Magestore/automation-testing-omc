<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 3:59 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\OrderListByStaff;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class OrderListByStaffReportRP23Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff
 * Precondition and setup steps:
 * Create some orders by some different staffs
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Order list by staff
 * Acceptance Criteria:
 * Orders just created will be updated and shown on corresponding staffs row
 */
class OrderListByStaffReportRP23Test extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'MX';
    /* end tags */

    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    protected $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;

    /**
     * WebPOSAdminReportDashboard page.
     *
     * @var WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     */
    protected $webPOSAdminReportDashboard;

    /**
     * OrderListByStaff page.
     *
     * @var OrderListByStaff $orderListByStaff
     */
    protected $orderListByStaff;

    /**
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param OrderListByStaff $orderListByStaff
     * @param WebposIndex $webposIndex
     * @param AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        OrderListByStaff $orderListByStaff,
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->orderListByStaff = $orderListByStaff;
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    public function test
    (
        array $shifts,
        $products,
        Pos $pos,
        FixtureFactory $fixtureFactory
    )
    {
        /**@var Location $location */
        $location = $fixtureFactory->createByCode('location', ['dataset' => 'default']);
        $location->persist();
        $locationId = $location->getLocationId();
        $posData = $pos->getData();
        $posData['location_id'] = [$locationId];
        /**@var Pos $pos */
        $pos = $fixtureFactory->createByCode('pos', ['data' => $posData]);
        $pos->persist();
        $posId = $pos->getPosId();

        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staff_ms61']);
        $staffData = $staff->getData();
        $staffData['location_id'] = [$locationId];
        $staffData['pos_ids'] = [$posId];
        /**@var Staff $staff */
        $staff = $fixtureFactory->createByCode('staff', ['data' => $staffData]);
        $staff->persist();
        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposByStaff',
            [
                'staff' => $staff,
                'hasOpenSession' => false,
                'hasWaitOpenSessionPopup' => false
            ]
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposOpenSessionStep'
        )->run();

        $result = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        $orderIdInWebpos = 0;
        if ($result && $result["orderId"]) {
            $orderIdInWebpos = $result["orderId"];
        }

        // Preconditions
        $this->orderListByStaff->open();
        $this->orderListByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        $shifts['period_type'] = $staff->getDisplayName();
        $this->orderListByStaff->getFilterBlock()->viewsReport($shifts);
        $this->orderListByStaff->getActionsBlock()->showReport();

        $orderIdInBackend = $this->webPOSAdminReportDashboard->getReportDashboard()->getOrderIdInReportGrid()->getText();
        self::assertEquals(
            $orderIdInWebpos,
            $orderIdInBackend,
            'The Order Id Just Created in Webpos ' . $orderIdInWebpos . '. It is not updated in Table Body Of Order List By Staff Report.'
        );
    }
}