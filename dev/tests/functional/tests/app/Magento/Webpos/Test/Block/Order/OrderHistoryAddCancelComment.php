<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 13:33
 */

namespace Magento\Webpos\Test\Block\Order;

use Magento\Mtf\Block\Block;
/**
 * Class OrderHistoryAddCancelComment
 * @package Magento\Webpos\Test\Block\Order
 */
class OrderHistoryAddCancelComment extends Block
{
	public function getCancelButton()
	{
		return $this->_rootElement->find('.close');
	}

	public function getSaveButton()
	{
		return $this->_rootElement->find('.btn-save');
	}

	public function getCommentInput()
	{
		return $this->_rootElement->find('#input-add-cancel-comment-order');
	}

	public function waitForCommentInputVisible()
	{
		return $this->waitForElementVisible('#input-add-cancel-comment-order');
	}
}