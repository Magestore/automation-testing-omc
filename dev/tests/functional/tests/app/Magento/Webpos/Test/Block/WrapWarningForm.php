<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 18/04/2018
 * Time: 11:05
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class WrapWarningForm
 * @package Magento\Webpos\Test\Block
 */
class WrapWarningForm extends Block
{
    public function waitForWrapWarningFormVisible() {
        $this->waitForElementVisible('.wrap-warning-form');
    }

    //Start wrap warning form after login
    public function getWrapWarningForm() {
        return $this->_rootElement->find('.wrap-warning-form');
    }

    public function getButtonContinue() {
        return $this->_rootElement->find('button.btn-default');
    }
}