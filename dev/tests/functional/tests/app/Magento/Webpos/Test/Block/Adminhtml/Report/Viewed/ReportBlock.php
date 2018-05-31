<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/25/18
 * Time: 4:30 PM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Report\Viewed;


use Magento\Mtf\Client\Locator;
use Magento\Reports\Test\Block\Adminhtml\Sales\Orders\Viewed\FilterGrid;

class ReportBlock extends FilterGrid
{
    public function getTableFieldByTitle($title)
    {
        return $this->_rootElement->find('.//table/thead/tr//th/span[text()="' . $title . '"]', locator::SELECTOR_XPATH);
    }

    public function getReportFirtRow()
    {
        return $this->_rootElement->find('tbody tr:first-child');
    }

    public function getSaleTotal()
    {
        return $this->_rootElement->find('tfoot .col-sales-total');
    }

    public function waitLoader()
    {
        $this->waitForElementVisible('.data-grid');
    }

    public function getLastRowLocation()
    {
        return $this->_rootElement->find('tbody tr:last-child td:nth-child(1)')->getText();
    }
}