<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 10:47 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaff;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class SaleByStaffRP08Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Create an order"
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by Staff"
 * Acceptance Criteria:
 * Order Count and Total sale of that staff will be updated
 */
class SaleByStaffRP08Test extends Injectable
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
     * SalesByStaff page.
     *
     * @var SalesByStaff $salesByStaff
     */
    protected $salesByStaff;

    /**
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SalesByStaff $salesByStaff
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByStaff $salesByStaff,
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByStaff = $salesByStaff;
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    public function test
    (
        $products
    )
    {
        // Preconditions
        $this->salesByStaff->open();
        $this->salesByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $orderCountBodyBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getOrderCountBody()->getText();
        $orderCountFootBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getOrderCountFoot()->getText();
        $salesTotalBodyBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesTotalBody()->getText();
        $salesTotalFootBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesTotalFoot()->getText();

        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();

        // Preconditions
        $this->salesByStaff->open();
        $this->salesByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $orderCountBodyAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getOrderCountBody()->getText();
        $orderCountFootAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getOrderCountFoot()->getText();
        $salesTotalBodyAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesTotalBody()->getText();
        $salesTotalFootAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesTotalFoot()->getText();

//        $before = floatval(str_replace('$', '',$orderCountBodyBefore));
//        $after = floatval(str_replace('$', '',$orderCountBodyAfter));
//        self::assertGreaterThan(
//            $before,
//            $after,
//            'The Order Count In Table Body Of Report Form By Staff was not updated.'
//        );
        $before = floatval(str_replace('$', '',$orderCountFootBefore));
        $after = floatval(str_replace('$', '',$orderCountFootAfter));
        self::assertGreaterThan(
            $before,
            $after,
            'The Order Count In Table Foot Of Report Form By Staff was not updated.'
        );
//        $before = floatval(str_replace('$', '',$salesTotalBodyBefore));
//        $after = floatval(str_replace('$', '',$salesTotalBodyAfter));
//        self::assertGreaterThan(
//            $before,
//            $after,
//            'The Sales Total Body In Table Body Of Report Form By Staff was not updated.'
//        );
        $before = floatval(str_replace('$', '',$salesTotalFootBefore));
        $after = floatval(str_replace('$', '',$salesTotalFootAfter));
        self::assertGreaterThan(
            $before,
            $after,
            'The Sales Total Foot In Table Body Of Report Form By Staff was not updated.'
        );
    }
}