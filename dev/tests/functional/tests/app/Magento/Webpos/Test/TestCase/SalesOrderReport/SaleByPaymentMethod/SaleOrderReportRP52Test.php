<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 29/05/2018
 * Time: 15:29
 */

namespace Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\SalesByPayment;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class SaleOrderReportRP52Test
 * @package Magento\Webpos\Test\TestCase\SalesOrderReport\SaleByPaymentMethod
 *
 * Precondition:
 * Create some orders and use some different payment methods to checkout
 *
 * Steps:
 * 1. Login backend
 * 2. Go to Webpos > Reports > Sale by payment method
 *
 * Acceptance:
 * Order Count and Total sale of that staff will be updated for payments to checkout
 *
 */
class SaleOrderReportRP52Test extends Injectable
{

    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * SalesByPayment page.
     *
     * @var SalesByPayment $salesByPayment
     */
    protected $salesByPayment;

    public function __inject(
        SalesByPayment $salesByPayment,
        WebposIndex $webposIndex
    )
    {
        $this->salesByPayment = $salesByPayment;
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        // Precondition
        $this->salesByPayment->open();
        $cashInOrderCount = $this->salesByPayment->getPaymentReport()->getCashInOrderCount()->getText();
        $cashInSalesTotal = $this->salesByPayment->getPaymentReport()->getCashInOrderCount()->getText();

    }

}