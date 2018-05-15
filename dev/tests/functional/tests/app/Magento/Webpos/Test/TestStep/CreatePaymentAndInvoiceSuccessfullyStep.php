<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/2/2018
 * Time: 3:01 PM
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\OrderHistory\Payment\AssertPaymentSuccess;
use Magento\Webpos\Test\Constraint\OrderHistory\Invoice\AssertInvoiceSuccess;

/**
 * Class CreatePaymentAndInvoiceSuccessfullyStep
 * @package Magento\Webpos\Test\TestStep
 */
class CreatePaymentAndInvoiceSuccessfullyStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var AssertPaymentSuccess
     */
    protected $assertPaymentSuccess;

    /**
     * @var AssertInvoiceSuccess
     */
    protected $assertInvoiceSuccess;

    /**
     * CreatePaymentAndInvoiceSuccessfullyStep constructor.
     * @param WebposIndex $webposIndex
     * @param AssertPaymentSuccess $assertPaymentSuccess
     * @param AssertInvoiceSuccess $assertInvoiceSuccess
     */
    public function __construct(
        WebposIndex $webposIndex,
        AssertPaymentSuccess $assertPaymentSuccess,
        AssertInvoiceSuccess $assertInvoiceSuccess
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertPaymentSuccess = $assertPaymentSuccess;
        $this->assertInvoiceSuccess = $assertInvoiceSuccess;
    }

    /**
     * @return array|mixed
     */
    public function run()
    {
        // Go to Order History
        $this->webposIndex->open();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        sleep(1);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(1);
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();
        // Open shipment popup
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getTakePaymentButton()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryPayment()->getCashInMethod()->click();
        $this->webposIndex->getOrderHistoryPayment()->getSubmitButton()->click();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        // Assert Take Payment Success
        $this->assertPaymentSuccess->processAssert($this->webposIndex);
        sleep(1);
        // Invoice
        $this->webposIndex->getOrderHistoryOrderViewFooter()->getInvoiceButton()->click();
        sleep(1);
        $this->webposIndex->getOrderHistoryContainer()->waitOrderHistoryInvoiceIsVisible();
        $this->webposIndex->getOrderHistoryInvoice()->getSubmitButton()->click();
        sleep(1);
        $this->webposIndex->getModal()->getOkButton()->click();
        sleep(1);
        $this->assertInvoiceSuccess->processAssert($this->webposIndex);

        return ['status' => 'Processing'];
    }
}