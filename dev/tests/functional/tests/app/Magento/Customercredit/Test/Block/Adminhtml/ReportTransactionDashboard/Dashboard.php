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

/**
 * Class Dashboard
 * @package Magento\Customercredit\Test\Block\Adminhtml\ReportTransactionDashboard
 */
class Dashboard extends Block
{
    /**
     * @var string
     */
    protected $dashBoard = '.dashboard-container';

    /**
     * @return bool
     */
    public function dashBoardIsVisible()
    {
        return $this->_rootElement->find($this->dashBoard, Locator::SELECTOR_CSS)->isVisible();
    }
}