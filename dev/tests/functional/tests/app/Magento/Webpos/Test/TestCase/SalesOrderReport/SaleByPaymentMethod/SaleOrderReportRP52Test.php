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

    public function test($products)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'magestore_webpos_all_payment']
        )->run();

        // Precondition
        $cashInOrderCount = "0";
        $cashInSalesTotal = "0";
        $customPayment1OrderCount = "0";
        $customPayment1SalesTotal = "0";
        $this->salesByPayment->open();
        if ($this->salesByPayment->getPaymentReport()->getCashInOrderCount()->isVisible()) {
            $cashInOrderCount = $this->salesByPayment->getPaymentReport()->getCashInOrderCount()->getText();
        }
        if ($this->salesByPayment->getPaymentReport()->getCashInSalesTotal()->isVisible()) {
            $cashInSalesTotal = $this->salesByPayment->getPaymentReport()->getCashInSalesTotal()->getText();
        }
        if ($this->salesByPayment->getPaymentReport()->getCustomPayment1OrderCount()->isVisible()) {
            $customPayment1OrderCount = $this->salesByPayment->getPaymentReport()->getCustomPayment1OrderCount()->getText();
        }
        if ($this->salesByPayment->getPaymentReport()->getCustomPayment1SalesTotal()->isVisible()) {
            $customPayment1SalesTotal = $this->salesByPayment->getPaymentReport()->getCustomPayment1SalesTotal()->getText();
        }

        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $paymentAmountCashIn = 0;
        $result = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            ['products' => $products]
        )->run();
        if ($result && $result["paymentAmount"]) {
            $paymentAmountCashIn = $result["paymentAmount"];
        }

        $paymentAmountCustomPayment1 = 0;
        $result = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\WebposAddProductToCartThenCheckoutStep',
            [
                'products' => $products,
                'paymentMethod' => 'cp1forpos'
            ]
        )->run();
        if ($result && $result["paymentAmount"]) {
            $paymentAmountCustomPayment1 = $result["paymentAmount"];
        }

        $cashInOrderCountNew = "0";
        $cashInSalesTotalNew = "0";
        $customPayment1OrderCountNew = "0";
        $customPayment1SalesTotalNew = "0";
        $this->salesByPayment->open();
        if ($this->salesByPayment->getPaymentReport()->getCashInOrderCount()->isVisible()) {
            $cashInOrderCountNew = $this->salesByPayment->getPaymentReport()->getCashInOrderCount()->getText();
        }
        if ($this->salesByPayment->getPaymentReport()->getCashInSalesTotal()->isVisible()) {
            $cashInSalesTotalNew = $this->salesByPayment->getPaymentReport()->getCashInSalesTotal()->getText();
        }
        if ($this->salesByPayment->getPaymentReport()->getCustomPayment1OrderCount()->isVisible()) {
            $customPayment1OrderCountNew = $this->salesByPayment->getPaymentReport()->getCustomPayment1OrderCount()->getText();
        }
        if ($this->salesByPayment->getPaymentReport()->getCustomPayment1SalesTotal()->isVisible()) {
            $customPayment1SalesTotalNew = $this->salesByPayment->getPaymentReport()->getCustomPayment1SalesTotal()->getText();
        }

        // Acceptance
        $this->assertEquals(
            floatval($customPayment1OrderCount) + 1,
            floatval($customPayment1OrderCountNew),
            'Order Count Custom payment 1 not correct'
        );
        $this->assertEquals(
            floatval($cashInOrderCount) + 1,
            floatval($cashInOrderCountNew),
            'Order Count Cash in not correct'
        );
        $this->assertEquals(
            $this->convertPriceFormatToDecimal($customPayment1SalesTotal) + $paymentAmountCustomPayment1,
            $this->convertPriceFormatToDecimal($customPayment1SalesTotalNew),
            'Total sales Custom payment 1 not correct'
        );
        $this->assertEquals(
            $this->convertPriceFormatToDecimal($cashInSalesTotal) + $paymentAmountCashIn,
            $this->convertPriceFormatToDecimal($cashInSalesTotalNew),
            'Total sales Cash in not correct'
        );
    }

    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'magestore_webpos_specific_payment']
        )->run();
    }

    /**
     * convert string price format to decimal
     * @param $string
     * @param $symbol
     * @return float|int|null
     */
    public function convertPriceFormatToDecimal($string, $symbol = '$')
    {
        $result = null;
        $negative = false;
        if ($string[0] === '-') {
            $negative = true;
            $string = str_replace('-', '', $string);
        }
        $string = str_replace($symbol, '', $string);
        $result = floatval($string);
        if ($negative) {
            $result = -1 * abs($result);
        }
        return $result;
    }
}