<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 13:21
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\Order\AssertOrderIsShownInOrderList;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationOrderTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var OrderIndex
	 */
	protected $orderIndex;

	/**
	 * @var SalesOrderView
	 */
	protected $salesOrderView;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	/**
	 * @var AssertOrderIsShownInOrderList
	 */
	protected $assertOrderIsShownInOrderList;

	public function __inject(
		WebposIndex $webposIndex,
		OrderIndex $orderIndex,
		SalesOrderView $salesOrderView,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertOrderIsShownInOrderList $assertOrderIsShownInOrderList
	)
	{
		$this->webposIndex = $webposIndex;
		$this->orderIndex = $orderIndex;
		$this->salesOrderView = $salesOrderView;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertOrderIsShownInOrderList = $assertOrderIsShownInOrderList;
	}

	public function test(
		Staff $staff,
		OrderInjectable $order,
		$status
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		// Add new Order in backend
		$order->persist();

		// Reload Order
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$itemText = "Order";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

		// Assert Order reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
		$this->assertOrderIsShownInOrderList->processAssert($this->webposIndex, $order->getId(), $status, $action);

		// Cancel order in backend
		$filter = ['id' => $order->getId()];

		// Steps
		$this->orderIndex->open();
		$this->orderIndex->getSalesOrderGrid()->searchAndOpen($filter);
		$this->salesOrderView->getPageActions()->cancel();


		// Update Cancel
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();

		// Assert Shift update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);

		$status = 'Cancelled';
		$this->assertOrderIsShownInOrderList->processAssert($this->webposIndex, $order->getId(), $status, $action);

	}
}