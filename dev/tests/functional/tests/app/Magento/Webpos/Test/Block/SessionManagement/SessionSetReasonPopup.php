<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/12/2018
 * Time: 4:36 PM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;

/**
 * Class SessionSetReasonPopup
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionSetReasonPopup extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getNotice()
    {
        return $this->_rootElement->find('.cash-counting-notice');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getCancelButton()
    {
        return $this->_rootElement->find('.cancel');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getConfirmButton()
    {
        return $this->_rootElement->find('.link-cl-cfg');
    }
    public function waitConfirmButton()
    {
        $confirm = $this->_rootElement->find('.link-cl-cfg');
        if (!$confirm->isVisible()) {
            $this->waitForElementVisible('.link-cl-cfg');
        }
    }

    public function waitForConfirmButtonVisible()
    {
        $this->waitForElementVisible('.link-cl-cfg');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getReason(){
        return $this->_rootElement->find('#reason');
    }
}