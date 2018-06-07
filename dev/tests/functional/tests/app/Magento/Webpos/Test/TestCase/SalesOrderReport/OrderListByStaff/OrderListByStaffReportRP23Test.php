<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/26/18
 * Time: 3:59 PM
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\OrderListByStaff;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
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

    /**
     * @param array $shifts
     * @param CatalogProductSimple $product
     */
    public function test
    (
        array $shifts,
        CatalogProductSimple $product
    )
    {
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
        $orderIdInWebpos = str_replace('#', '', $this->webposIndex->getCheckoutSuccess()->getOrderId()->getText());
        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(2);
        // Preconditions
        $this->orderListByStaff->open();
        $this->orderListByStaff->getMessagesBlock()->clickLinkInMessage('notice', 'here');
        if (isset($shifts['period_type']) && !$this->webPOSAdminReportDashboard->getReportDashboard()->getPeriorTypeOptionByName($shifts['period_type'])->isPresent()) {
            unset($shifts['period_type']);
            $this->webPOSAdminReportDashboard->getReportDashboard()->setFirstOptionPrediodType();
        }
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