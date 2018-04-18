<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 23/11/2017
 * Time: 16:06
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;


use Magento\InventorySuccess\Test\Page\Adminhtml\TranferFromExternalHistory;
use Magento\Mtf\TestCase\Injectable;

class InventoryTranferFromExternalAddNewTranferFormTest extends Injectable
{
	/**
	 * @var TranferFromExternalHistory
	 */
	protected $tranferFromExternalHistory;

	public function __inject(
		TranferFromExternalHistory $tranferFromExternalHistory
	)
	{
		$this->tranferFromExternalHistory = $tranferFromExternalHistory;
	}

	public function test()
	{
		$this->tranferFromExternalHistory->open();
		$this->tranferFromExternalHistory->getPageActionsBlock()->addNewTranfer();
	}
}