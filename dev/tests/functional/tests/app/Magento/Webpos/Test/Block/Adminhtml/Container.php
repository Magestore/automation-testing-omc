<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/8/2017
 * Time: 9:06 AM
 */
namespace Magento\Webpos\Test\Block\Adminhtml;

use Magento\Mtf\Block\Block;

/**
 * Class Container
 * @package Magento\Webpos\Test\Block\Adminhtml
 */

class Container extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */

    public function getFieldDenominationName()
    {
        return $this->_rootElement->find('#page_denomination_name');
    }
    public function getFieldDenominationValue()
    {
        return $this->_rootElement->find('#page_denomination_value');
    }
    public function getFieldDenominationSortOrder()
    {
        return $this->_rootElement->find('#page_sort_order');
    }
}