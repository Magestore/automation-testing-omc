<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:31
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
use Magento\Mtf\Client\Locator;

/**
 * Class OrderHistoryOrderViewFooter
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryOrderViewFooter extends Block
{
    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getPrintButton()
	{
		return $this->_rootElement->find('button.print');
	}

    /**
     * @return \Magento\Mtf\Client\ElementInterface
     */
    public function getInvoiceButton()
	{
		return $this->_rootElement->find('button.invoice');
	}

    /**
     * @param $label
     * @return array|string
     */
    public function getRowValue($label)
	{
		return $this->_rootElement->find('//*[@id="webpos_order_view_container"]/footer/div[1]/table/tbody/tr/td[text()="'.$label.'"]/../td[2]', Locator::SELECTOR_XPATH)->getText();
	}

    /**
     * @return array|string
     */
    public function getSubtotal()
	{
		$label = 'Subtotal';
		return $this->getRowValue($label);
	}

    /**
     * @return array|string
     */
    public function getShipping()
	{
		$label = 'Shipping';
		return $this->getRowValue($label);
	}

    /**
     * @return array|string
     */
    public function getTax()
	{
		$label = 'Tax';
		return $this->getRowValue($label);
	}

    /**
     * @return array|string
     */
    public function getDiscount()
	{
		$label = 'Discount';
		return $this->getRowValue($label);
	}

    /**
     * @return array|string
     */
    public function getGrandTotal()
	{
		$label = 'Grand Total';
		return $this->getRowValue($label);
	}

    /**
     * @return array|string
     */
    public function getTotalPaid()
	{
		$label = 'Total Paid';
		return $this->getRowValue($label);
	}

    /**
     * @return array|string
     */
    public function getTotalRefunded()
	{
		$label = 'Total Refunded';
		return $this->getRowValue($label);
	}

    /**
     * @return bool|null
     */
    public function waitForTotalRefundedVisible()
    {
        return $this->waitForElementVisible('//*[@id="webpos_order_view_container"]/footer/div[1]/table/tbody/tr/td[text()="Total Refunded"]/..', Locator::SELECTOR_XPATH);
    }


	public function getRow($label)
	{
		return $this->_rootElement->find('//*[@id="webpos_order_view_container"]/footer/div[1]/table/tbody/tr/td[text()="'.$label.'"]/../td[2]', Locator::SELECTOR_XPATH);
	}

}