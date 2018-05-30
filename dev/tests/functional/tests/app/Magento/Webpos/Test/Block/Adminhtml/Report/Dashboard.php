<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/25/18
 * Time: 8:28 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Report;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class Dashboard
 * @package Magento\Webpos\Test\Block\Adminhtml\Report
 */
class Dashboard extends Block
{
    protected $col = './/th[span = "%s"]';

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getAdminReportWebpos() {
        return $this->_rootElement->find('.admin-report-webpos');
    }

    public function getSalesReportPeriodType() {
        return $this->_rootElement->find('#sales_report_period_type');
    }

    public function getSalesReportFormDate() {
        return $this->_rootElement->find('#sales_report_from');
    }
    public function getSalesReportToDate() {
        return $this->_rootElement->find('#sales_report_to');
    }
    public function getSalesReportShowOrderStatuses() {
        return $this->_rootElement->find('#sales_report_show_order_statuses');
    }

    /**
     * Check column Visible
     */
    public function columnIsVisible($column)
    {
        return $this->_rootElement->find(sprintf($this->col, $column), Locator::SELECTOR_XPATH)->isVisible();
    }

    public function getSalesReportOderStatuses()
    {
        return $this->_rootElement->find('#sales_report_order_statuses');
    }

    public function setSalesReportOderStatuses($text)
    {
        $this->getSalesReportOderStatuses()->click();
        $this->_rootElement->find('//*[@id="sales_report_order_statuses"]/option[text()="'.$text.'"]', Locator::SELECTOR_XPATH)->click();
    }

    public function getTypeExport()
    {
        return $this->_rootElement->find('//*[@id="container"]/div[2]/div[1]/div[1]/div/select', Locator::SELECTOR_XPATH);
    }
    public function clickTypeExport($type)
    {
        $this->getTypeExport()->click();
        return $this->_rootElement->find('//*[@id="container"]/div[2]/div[1]/div[1]/div/select/option[text()="'.$type.'"]', Locator::SELECTOR_XPATH);
    }
    public function getButtonExport()
    {
        return $this->_rootElement->find('//*[@id="container"]/div[2]/div[1]/div[1]/div/button', Locator::SELECTOR_XPATH);
    }

    public function getOrderCountBody()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody td.col-orders');
    }
    public function getOrderCountFoot()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tfoot .col-orders');
    }

    public function getSalesTotalBody()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody .col-sales-total');
    }
    public function getSalesTotalFoot()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tfoot .col-sales-total');
    }

    public function getLastOrderCountBodyDaily()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody tr:last-child td.col-orders');
    }
    public function getLastOrderCountFootDaily()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tfoot tr:last-child .col-orders');
    }

    public function getLastSalesTotalBodyDaily()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody tr:last-child .col-sales-total');
    }
    public function getLastSalesTotalFootDaily()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tfoot tr:last-child .col-sales-total');
    }

    public function getPaymentMethod()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody .col-payment.method_title');
    }
    public function getStaffName()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody .col-webpos_staff_name');
    }
    public function getOrderIdInReportGrid()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody tr:last-child .col-increment_id');
    }
    public function getStatusOrder()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody .col-order_status\2e label');
    }
}