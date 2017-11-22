<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 30/10/2017
 * Time: 08:29
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\Shift\AssertShiftIsInShiftList;
use Magento\Webpos\Test\Fixture\Shift;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationShiftTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	/**
	 * @var AssertShiftIsInShiftList
	 */
	protected $assertShiftIsInShiftList;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	public function __inject(
		WebposIndex $webposIndex,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertShiftIsInShiftList $assertShiftIsInShiftList,
		FixtureFactory $fixtureFactory
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertShiftIsInShiftList = $assertShiftIsInShiftList;
		$this->fixtureFactory = $fixtureFactory;
	}

	public function test(
		Staff $staff,
		Shift $shift,
		Shift $editShift
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

		// Add new Shift
		$shift->persist();

		// Reload Shift
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$shiftText = "Shift";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($shiftText)->click();

		// Assert shift reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $shiftText, $action);
		$this->assertShiftIsInShiftList->processAssert($this->webposIndex, $shift, $action);

		// Edit Shift
		$shift = $this->prepareShift($editShift, $shift);
		$shift->persist();

		// Update Shift
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($shiftText)->click();

		// Assert Shift update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $shiftText, $action);
		$this->assertShiftIsInShiftList->processAssert($this->webposIndex, $shift, $action);

	}


	/**
	 * @param Shift $shift
	 * @param Shift $initialShift
	 * @return Shift
	 */
	protected function prepareShift(Shift $shift, Shift $initialShift)
	{
		$data = [
			'data' => array_merge(
				$initialShift->getData(),
				$shift->getData()
			)
		];
		return $this->fixtureFactory->createByCode('shift', $data);
	}
}