<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/11/2017
 * Time: 09:37
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
/**
 * Class PopupChangeCustomer
 * @package Magento\Webpos\Test\Block
 */
class PopupChangeCustomer extends Block
{
    public function getCreateCustomer()
    {
        return $this->_rootElement->find('#btn-add-new-customer');
    }
    public function getUseGuest()
    {
        return $this->_rootElement->find('.btn-use-guest');
    }
    public function getSearchCustomer()
    {
        return $this->_rootElement->find('#search-customer');
    }
    public function getItemCustomerList()
    {
        return $this->_rootElement->find('.list-customer-old li');
    }
}