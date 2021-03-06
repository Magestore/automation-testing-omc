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
    public function getAdminReportWebpos()
    {
        return $this->_rootElement->find('.admin-report-webpos');
    }

    public function getSalesReportPeriodType()
    {
        return $this->_rootElement->find('#sales_report_period_type');
    }

    public function getSalesReportFormDate()
    {
        return $this->_rootElement->find('#sales_report_from');
    }

    public function getSalesReportToDate()
    {
        return $this->_rootElement->find('#sales_report_to');
    }

    public function getSalesReportShowOrderStatuses()
    {
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

    public function setLocation($location)
    {
        return $this->_rootElement->find('#sales_report_period_type', locator::SELECTOR_CSS, 'select')->setValue($location);
    }

    public function getLocation()
    {
        return $this->_rootElement->find('#sales_report_period_type')->getValue();
    }

    public function setSalesReportOderStatuses($text)
    {
//        $this->getSalesReportOderStatuses()->click();
        $this->_rootElement->find('//*[@id="sales_report_order_statuses"]/option[text()="' . $text . '"]', Locator::SELECTOR_XPATH)->click();
    }

    public function setOrderStatusByTitle($title)
    {
        $this->_rootElement->find('#sales_report_order_statuses', Locator::SELECTOR_CSS, 'select')->setValue($title);
    }

    public function getOrderStatus()
    {
        return $this->_rootElement->find('#sales_report_order_statuses', locator::SELECTOR_CSS, 'select')->getValue();
    }

    public function setOrderStatus($text)
    {
        $this->_rootElement->find('#sales_report_order_statuses', locator::SELECTOR_CSS, 'select')->setValue($text);
    }

    public function getTypeExport()
    {
        return $this->_rootElement->find('//*[@id="container"]/div[2]/div[1]/div[1]/div/select', Locator::SELECTOR_XPATH);
    }

    public function clickTypeExport($type)
    {
        $this->getTypeExport()->click();
        return $this->_rootElement->find('//*[@id="container"]/div[2]/div[1]/div[1]/div/select/option[text()="' . $type . '"]', Locator::SELECTOR_XPATH);
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
        return $this->_rootElement->find('//tbody//*[contains(normalize-space(@class), "col-payment.method_title")][1]', Locator::SELECTOR_XPATH);
    }

    public function getStaffName()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody .col-webpos_staff_name');
    }

    public function getLocationName()
    {
        return $this->_rootElement->find('.//div[@id="container"]//tbody//tr[1]/td', locator::SELECTOR_XPATH);
    }

    public function getOrderIdInReportGrid()
    {
        return $this->_rootElement->find('#container div.admin__data-grid-wrap table tbody tr:last-child .col-increment_id');
    }

    public function getStatusOrder()
    {
        return $this->_rootElement->find('//tbody//*[contains(normalize-space(@class), "col-order_status.label")]', Locator::SELECTOR_XPATH);
    }

    public function getFirtRowDataGrid()
    {
        return $this->_rootElement->find('tbody >tr');
    }

    public function getLasRowDataGrid()
    {
        return $this->_rootElement->find('tbody >tr:last-child');
    }

    public function getFirstDateGrid()
    {
        return $this->getFirtRowDataGrid()->find('.col-created_date')->getText();
    }

    public function getLastDateGrid()
    {
        return $this->getLasRowDataGrid()->find('.col-created_date')->getText();
    }

    public function getLastLocationGrid()
    {
        if (strpos($this->getLasRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
            return $this->getLasRowDataGrid()->find('.//td[contains(normalize-space(@class), "col-location.display_name")]', locator::SELECTOR_XPATH)->getText();
        }
        return 'We couldn\'t find any records.';
    }

    public function getLastPaymentGrid()
    {
        if (strpos($this->getLasRowDataGrid()->getAttribute('class'), 'data-grid-tr-no-data') === false) {
            return $this->getLasRowDataGrid()->find('.//td[contains(normalize-space(@class), "col-payment.method_title")]', locator::SELECTOR_XPATH)->getText();
        }
        return 'We couldn\'t find any records.';
    }

    public function waitLoader()
    {
        $this->waitForElementVisible('.data-grid tbody tr');
    }

    public function getPeriorTypeOptionByName($name)
    {
        return $this->_rootElement->find('//select[@id="sales_report_period_type"]//option[text()="' . $name . '"]', locator::SELECTOR_XPATH);
    }

    public function setFirstOptionPrediodType()
    {
        $option = $this->getFirstOptionPeriodType()->getText();
        $this->_rootElement->find('//select[@id="sales_report_period_type"]', locator::SELECTOR_XPATH, 'select')->setValue($option);
    }

    public function getFirstOptionPeriodType()
    {
        return $this->_rootElement->find('//select[@id="sales_report_period_type"]//option[2]', locator::SELECTOR_XPATH);
    }

    public function checkHasData()
    {
        $this->waitLoader();
        return !$this->getFirtRowDataGrid()->find('.empty-text')->isVisible();

    }
}