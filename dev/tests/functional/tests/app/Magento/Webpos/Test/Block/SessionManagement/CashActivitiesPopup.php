<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/9/2018
 * Time: 8:48 AM
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;

class CashActivitiesPopup extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface[]
     */
    public function getTransactionsWithValue()
    {
        return $this->_rootElement->getElements('span[data-bind="text: $parent.formatPrice(value)"]');
    }

    /**
     * @return \Magento\Mtf\Client\ElementInterface[]
     */
    public function getTransactionsWithNote()
    {
        return $this->_rootElement->getElements('span[data-bind="text: note"]');
    }
}