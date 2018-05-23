<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/15/2018
 * Time: 8:45 AM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class SessionPrintShiftPopup
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionPrintShiftPopup extends Block
{
    public function getZreportTitle()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/h2[2]/span', Locator::SELECTOR_XPATH);
    }

    public function getXreportTitle()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/h2[1]/span', Locator::SELECTOR_XPATH);
    }

    public function getDrawerNumber()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/span[@class="drawer-number"]', Locator::SELECTOR_XPATH);
    }

    public function getPosName()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="info-datetime"]/tbody/tr[1]/td[2]/span[@data-bind="text: posName"]', Locator::SELECTOR_XPATH);
    }

    public function getStaffName()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="info-datetime"]/tbody/tr[2]/td[2]/span[@data-bind="text: staffName"]', Locator::SELECTOR_XPATH);
    }

    public function getOpened()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="info-datetime"]/tbody/tr[3]/td[2]/span[@data-bind="text: openedAtFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getClosed()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="info-datetime"]/tbody/tr[4]/td[2]/span[@data-bind="text: closedAtFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getOpeningAmount()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction"]/tbody/tr[1]/td[2]/span[@data-bind="text: floatAmountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getClosingAmount()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction"]/tbody/tr[2]/td[2]/span[@data-bind="text: closedAmountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getExpectedDrawer()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction"]/tbody/tr[3]/td[2]/span[@data-bind="text: theoretialClosingBalanceFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getTheoreticalClosingAmount()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction"]/tbody/tr[4]/td[2]/span[@data-bind="text: theoretialClosingBalanceFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getDifference()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction"]/tbody/tr[5]/td[2]/span[@data-bind="text: differenceAmountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getCashSales()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction list-transaction-second"]/tbody/tr[1]/td[2]/span[@data-bind="text: cashSaleFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getCashRefund()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction list-transaction-second"]/tbody/tr[2]/td[2]/span[@data-bind="text: cashRefundFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getPayIns()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction list-transaction-second"]/tbody/tr[3]/td[2]/span[@data-bind="text: cashAddedFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getPayouts()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction list-transaction-second"]/tbody/tr[4]/td[2]/span[@data-bind="text: cashRemovedFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getTotalSales()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="table table-total"]/tbody/tr[1]/td[2]/span[@data-bind="text: totalSalesFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getDiscount()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="table table-total"]/tbody/tr[2]/td[2]/span[@data-bind="text: discountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getRefund()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="table table-total"]/tbody/tr[5]/td[2]/span[@data-bind="text: refundFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getNetSales()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="table table-total"]/tbody/tr[6]/td[2]/span[@data-bind="text: netSaleFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getPaymentAmount($rowIndex = 1)
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="table table-payment"]/tbody/tr['.$rowIndex.']/td[2]/span[@data-bind="text: $parent.formatPrice(payment_amount)"]', Locator::SELECTOR_XPATH);
    }

    public function getTimeToPrint()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/h3[@class="title-box print-at-title"]', Locator::SELECTOR_XPATH);
    }


}