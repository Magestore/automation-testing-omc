<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 06/12/2017
 * Time: 11:20
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;
/**
 * Class CheckoutWebposCart
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutWebposCart extends Block
{
    public function getOrderSequence($value)
    {
        return $this->_rootElement->find('//*[@id="webpos_cart"]/header/div[1]/span[2]/span[1]/span[text()='.$value.']', Locator::SELECTOR_XPATH);
    }

    public function getIconChangeCustomer()
    {
        return $this->_rootElement->find('.icon-iconPOS-change-customer');
    }

    public function getCustomerTitleHeaderPage()
    {
        return $this->_rootElement->find('.actions-customer .title-header-page');
    }

    public function getIconPrevious()
    {
        return $this->_rootElement->find('.icon-iconPOS-previous');
    }
}