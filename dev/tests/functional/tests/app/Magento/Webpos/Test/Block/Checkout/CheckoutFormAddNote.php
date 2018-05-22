<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 16:37
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutFormAddNote
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\Block\CategoryRepository
 */
class CheckoutFormAddNote extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function waitAddOrderNote()
    {
        $posModal = $this->_rootElement->find('.pos_modal_link');
        if (!$posModal->isVisible()) {
            $this->waitForElementVisible('.pos_modal_link');
        }
    }
    public function getAddOrderNote()
    {
        return $this->_rootElement->find('.pos_modal_link');
    }
    public function waitFullScreenMode()
    {
        $this->waitForElementVisible('#fullscreen_link');
    }
    public function getFullScreenMode()
    {
        return $this->_rootElement->find('#fullscreen_link');
    }
}