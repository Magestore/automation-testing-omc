<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 10:47 AM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByStaff;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Webpos\Test\Page\Adminhtml\WebPOSAdminReportDashboard;
use Magento\Webpos\Test\Page\Adminhtml\SalesByStaff;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
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

    /**
     * @param CatalogProductSimple $product
     */
    public function test
    (
        CatalogProductSimple $product
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
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

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

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(2);
        // Preconditions
        $this->salesByStaff->open();
        $this->salesByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');

        $orderCountBodyAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getOrderCountBody()->getText();
        $orderCountFootAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getOrderCountFoot()->getText();
        $salesTotalBodyAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesTotalBody()->getText();
        $salesTotalFootAfter = $this->webPOSAdminReportDashboard->getReportDashboard()->getSalesTotalFoot()->getText();

        self::assertGreaterThan(
            $orderCountBodyBefore,
            $orderCountBodyAfter,
            'The Order Count In Table Body Of Report Form By Staff was not updated.'
        );
        self::assertGreaterThan(
            $orderCountFootBefore,
            $orderCountFootAfter,
            'The Order Count In Table Foot Of Report Form By Staff was not updated.'
        );
        self::assertGreaterThan(
            $salesTotalBodyBefore,
            $salesTotalBodyAfter,
            'The Sales Total Body In Table Body Of Report Form By Staff was not updated.'
        );
        self::assertGreaterThan(
            $salesTotalFootBefore,
            $salesTotalFootAfter,
            'The Sales Total Foot In Table Body Of Report Form By Staff was not updated.'
        );
    }
}