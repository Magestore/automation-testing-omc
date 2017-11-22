<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 08/11/2017
 * Time: 13:16
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Tax\Test\Page\Adminhtml\TaxRateIndex;
use Magento\Tax\Test\Page\Adminhtml\TaxRuleIndex;
use Magento\Tax\Test\Page\Adminhtml\TaxRuleNew;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\TaxRule\AssertTaxRuleApplyCorrectly;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationTaxRuleTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var TaxRuleIndex
	 */
	protected $taxRuleIndex;

	/**
	 * @var TaxRuleNew
	 */
	protected $taxRuleNew;

	/**
	 * @var TaxRateIndex
	 */
	protected $taxRateIndex;

	/**
	 * Fixture Factory.
	 *
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	/**
	 * @var AssertTaxRuleApplyCorrectly
	 */
	protected $assertTaxRuleApplyCorrectly;


	public function __inject(
		WebposIndex $webposIndex,
		TaxRuleIndex $taxRuleIndex,
		TaxRuleNew $taxRuleNew,
		TaxRateIndex $taxRateIndex,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertTaxRuleApplyCorrectly $assertTaxRuleApplyCorrectly
	)
	{
		$this->webposIndex = $webposIndex;
		$this->taxRuleIndex = $taxRuleIndex;
		$this->taxRuleNew = $taxRuleNew;
		$this->taxRateIndex = $taxRateIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertTaxRuleApplyCorrectly = $assertTaxRuleApplyCorrectly;
	}

	public function test(
		Staff $staff,
		Customer $customer,
		TaxRule $taxRule,
		$taxRate
	)
	{
		$customer->persist();

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		// Test Case: SYNC34
		// Add New Tax Rule
		$taxRule->persist();

		// Reload Tax Rule
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$action = 'Reload';

		$itemText = "Tax Rate";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

		// Assert Tax Rate reload success
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);

		$itemText = "Tax Classes";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

		// Assert Tax Class reload success
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);

		$itemText = "Tax rule";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

		// Assert Tax Rule reload success
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);

		$taxClass = $taxRule->getTaxProductClass()[1];
		// Get Tax Rate
		$this->taxRateIndex->open();
		$this->taxRateIndex->getTaxRateGrid()->search(['code' => $taxRule->getTaxRate()[0]]);
		$taxRate = (float) $this->taxRateIndex->getTaxRateGrid()->getRowsData(['rate'])[0]['rate'];
		$this->assertTaxRuleApplyCorrectly->processAssert($this->webposIndex, $customer, $taxClass, $taxRate, $action);


		// Test Case: SYNC34
		// Unselect a product tax class in tax rule
		$this->taxRuleIndex->open();
		$this->taxRuleIndex->getTaxRuleGrid()->searchAndOpen(['code' => $taxRule->getCode()]);
		$this->taxRuleNew->getDetailsBlock()->clickAdditionalSetting();
		$this->taxRuleNew->getDetailsBlock()->getProductTaxClassItem($taxClass)->click();
		$this->taxRuleNew->getFormPageActions()->save();

		// Update Tax Rule
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$action = 'SYNC34 - Update Tax Rule';

		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();

		// Assert Tax Rule update success
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
		$this->assertTaxRuleApplyCorrectly->processAssert($this->webposIndex, $customer, $taxClass, 0, $action);
	}

	public function tearDown()
	{
		$this->taxRuleIndex->open();
		$this->taxRuleIndex->getTaxRuleGrid()->resetFilter();
		while ($this->taxRuleIndex->getTaxRuleGrid()->isFirstRowVisible()) {
			$this->taxRuleIndex->getTaxRuleGrid()->openFirstRow();
			$this->taxRuleNew->getFormPageActions()->delete();
			$this->taxRuleNew->getModalBlock()->acceptAlert();
		}
	}
}