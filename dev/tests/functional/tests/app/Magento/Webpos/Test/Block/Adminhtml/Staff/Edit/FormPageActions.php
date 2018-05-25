<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/14/2018
 * Time: 8:47 AM
 */

namespace Magento\Webpos\Test\Block\Adminhtml\Staff\Edit;

/**
 * Class FormPageActions
 * @package Magento\Webpos\Test\Block\Adminhtml\Staff\Edit
 */
class FormPageActions extends \Magento\Backend\Test\Block\FormPageActions
{

    public function getResetButton()
    {
        return $this->_rootElement->find('#reset');
    }

    public function getSaveAndContinueButton()
    {
        return $this->_rootElement->find('#saveandcontinue');
    }

    public function getForceSignOutButton()
    {
        return $this->_rootElement->find('#signout');
    }
}