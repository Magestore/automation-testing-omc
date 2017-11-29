<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 7:58 AM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\ReportTransactionDashboard;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class Dashboard extends Block
{
    protected $dashBoard = '.dashboard-container';

    public function dashBoardIsVisible()
    {
        return $this->_rootElement->find($this->dashBoard, Locator::SELECTOR_CSS)->isVisible();
    }
}