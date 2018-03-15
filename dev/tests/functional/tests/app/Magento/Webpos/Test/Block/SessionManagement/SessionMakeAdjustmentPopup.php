<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 1:18 PM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

class SessionMakeAdjustmentPopup extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getModalTitle()
    {
        return $this->_rootElement->find('#modal-title-4');
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
    public function getDoneButton()
    {
        return $this->_rootElement->find('.btn-done');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getAmount()
    {
        return $this->_rootElement->find('//div[@class="amount-box"]/div[@class="input-box"]/input', Locator::SELECTOR_XPATH);
    }
}