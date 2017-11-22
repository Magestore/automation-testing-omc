<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 03/11/2017
 * Time: 15:36
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationShippingTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
	}

	public function test(
		Staff $staff,
		$configDataDataset,
		$action
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

		// Change Webpos shipping method title
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => $configDataDataset]
		)->run();

		$configData = $this->fixtureFactory->createByCode(
			'configData',
			['dataset' => $configDataDataset]
		);


		// Reload Country
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$itemText = "Shipping";
		if (strcmp($action, 'Update') == 0 ) {
			$this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();
		} else {
			$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();
		}

		$methodTitle = null;
		if (isset($configData->getData()['section']['carriers/webpos_shipping/name'])) {
			$methodTitle = $configData->getData()['section']['carriers/webpos_shipping/name']['value'];
		}

		$price = null;
		if (isset($configData->getData()['section']['carriers/webpos_shipping/price'])) {
			$price = $configData->getData()['section']['carriers/webpos_shipping/price']['value'];
		}

		return [
			'text' => $itemText,
			'methodTitle' => $methodTitle,
			'price' => $price
		];
	}

	public function tearDown()
	{
		$this->objectManager->getInstance()->create(
			'Magento\Config\Test\TestStep\SetupConfigurationStep',
			['configData' => 'sale_shipping_method_webpos_shipping_rollback']
		)->run();
	}
}