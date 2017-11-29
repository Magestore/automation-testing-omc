<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 24/11/2017
 * Time: 10:15
 */

namespace Magento\FulfilSuccess\Test\Block\Adminhtml\ReportIndex;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class PageMainContainer
 * @package Magento\FulfilSuccess\Test\Block\Adminhtml\ReportIndex
 */
class PageMainContainer extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getFulfilmentByStaff()
    {
        return $this->_rootElement->find('.icon-icon-Back-end-fulfilstaff');
    }
    public function getFulfilmentByStaffDaily()
    {
        return $this->_rootElement->find('.icon-icon-Back-end-fulfilstaffdaily');
    }
    public function getFulfilmentByWarehouse()
    {
        return $this->_rootElement->find('.icon-icon-Back-end-fulfilwarehouse');
    }
    public function getFulfilmentByWarehouseDaily()
    {
        return $this->_rootElement->find('.icon-icon-Back-end-fulfilwarehousedaily');
    }
    public function getColumnName($name)
    {
        return $this->_rootElement->find('//*[@id="page:main-container"]/div/div/div/div[4]/table/thead/tr/th[2]/span[text()="'.$name.'"]', Locator::SELECTOR_XPATH);
    }
}