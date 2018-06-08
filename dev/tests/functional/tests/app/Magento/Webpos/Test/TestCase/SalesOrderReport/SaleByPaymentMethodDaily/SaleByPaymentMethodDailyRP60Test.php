<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/30/18
 * Time: 10:16 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\Adminhtml\SalesByPaymentDaily;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class SaleByPaymentMethodDailyRP60Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethodDaily
 * Precondition and setup steps:
 * Create some orders use some different payment methods to checkout or take payment
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method (Daily)
 * Acceptance Criteria:
 * Order Count and Total sale of current day will be updated on current day
 */
class SaleByPaymentMethodDailyRP60Test extends Injectable
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
     * SalesByPaymentDaily page.
     *
     * @var SalesByPaymentDaily $salesByPaymentDaily
     */
    protected $salesByPaymentDaily;

    /**
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SalesByPaymentDaily $salesByPaymentDaily
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByPaymentDaily $salesByPaymentDaily,
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByPaymentDaily = $salesByPaymentDaily;
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    public function test
    (
        $products
    )
    {
        // Preconditions
        $this->salesByPaymentDaily->open();
        $this->salesByPaymentDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');

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
        $this->salesByPaymentDaily->open();
        $this->salesByPaymentDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');

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