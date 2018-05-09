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
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/span[@class="drawer-number"]/span[data-bind="text:shiftData().shift_id"]', Locator::SELECTOR_XPATH);
    }

    public function getInfoDatetime()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="info-datetime"]',Locator::SELECTOR_XPATH);
    }

    public function getPosName()
    {
        return $this->getInfoDatetime()->find('//tbody/tr[data-bind="visible:posName"]/td[2]/span', Locator::SELECTOR_XPATH);
    }

    public function getStaffName()
    {
        return $this->getInfoDatetime()->find('//tbody/tr[data-bind="visible:staffName"]/td[2]/span', Locator::SELECTOR_XPATH);
    }

    public function getOpened()
    {
        return $this->getInfoDatetime()->find('//tbody/tr/td[2]/span[data-bind="text: openedAtFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getClosed()
    {
        return $this->getInfoDatetime()->find('//tbody/tr/td[2]/span[data-bind="text: closedAtFormatted"]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getListTransaction()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="list-transaction"]', Locator::SELECTOR_XPATH);
    }

    public function getOpeningAmount()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: floatAmountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getClosingAmount()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: closedAmountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getTheoreticalClosingAmount()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: theoretialClosingBalanceFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getDifference()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: differenceAmountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getCashSales()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: cashSaleFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getCashRefund()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: cashRefundFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getPayIns()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: cashAddedFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getPayouts()
    {
        return $this->getListTransaction()->find('//tbody/tr/td/h4/span[data-bind="text: cashRemovedFormatted"]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getTableTotal()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="table table-total"]', Locator::SELECTOR_XPATH);
    }

    public function getTotalSales()
    {
        return $this->getTableTotal()->find('//tbody/tr/td/span[data-bind="text: totalSalesFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getDiscount()
    {
        return $this->getTableTotal()->find('//tbody/tr/td/span[data-bind="text: discountFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getRefund()
    {
        return $this->getTableTotal()->find('//tbody/tr/td/span[data-bind="text: giftcardFormatted"]', Locator::SELECTOR_XPATH);
    }

    public function getNetSales()
    {
        return $this->getTableTotal()->find('//tbody/tr/td/span[data-bind="text: netSaleFormatted"]', Locator::SELECTOR_XPATH);
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getTablePayment()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/table[@class="table table-payment"]', Locator::SELECTOR_XPATH);
    }

    public function getPaymentCashIn()
    {
        return $this->getTableTotal()->find('//tbody/tr/td/span[data-bind="text: $parent.formatPrice(payment_amount)"]', Locator::SELECTOR_XPATH);
    }

    public function getTimeToPrint()
    {
        return $this->_rootElement->find('//*[@id="zreport-print-content"]/div/h3[@class="title-box print-at-title"]', Locator::SELECTOR_XPATH);
    }


}