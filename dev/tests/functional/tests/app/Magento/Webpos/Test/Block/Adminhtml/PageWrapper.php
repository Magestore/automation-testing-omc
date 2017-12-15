<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/8/2017
 * Time: 9:14 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml;
use Magento\Ui\Test\Block\Adminhtml\DataGrid;
use Magento\Mtf\Client\Locator;

/**
 * Class PageWrapper
 * @package Magento\Webpos\Test\Block\Adminhtml
 */
class PageWrapper extends DataGrid
{
    public function getTitleAddDenomination()
    {
        return $this->_rootElement->find('.page-title');
    }
}