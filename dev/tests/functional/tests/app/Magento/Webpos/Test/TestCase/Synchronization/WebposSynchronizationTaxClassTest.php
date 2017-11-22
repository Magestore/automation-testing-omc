<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/11/2017
 * Time: 09:04
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Tax\Test\Fixture\TaxRule;
use Magento\Tax\Test\Page\Adminhtml\TaxRuleIndex;
use Magento\Tax\Test\Page\Adminhtml\TaxRuleNew;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\TaxClass\AssertTaxClassIsShownOnTaxClassField;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSynchronizationTaxClassTest
 * @package Magento\Webpos\Test\TestCase\Synchronization
 */
class WebposSynchronizationTaxClassTest extends Injectable
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
	 * @var AssertTaxClassIsShownOnTaxClassField
	 */
	protected $assertTaxClassIsShownOnTaxClassField;

	/**
	 * @param WebposIndex $webposIndex
	 * @param TaxRuleIndex $taxRuleIndex
	 * @param TaxRuleNew $taxRuleNew
	 * @param FixtureFactory $fixtureFactory
	 * @param AssertItemUpdateSuccess $assertItemUpdateSuccess
	 * @param AssertTaxClassIsShownOnTaxClassField $assertTaxClassIsShownOnTaxClassField
	 */
	public function __inject(
		WebposIndex $webposIndex,
		TaxRuleIndex $taxRuleIndex,
		TaxRuleNew $taxRuleNew,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertTaxClassIsShownOnTaxClassField $assertTaxClassIsShownOnTaxClassField
	)
	{
		$this->webposIndex = $webposIndex;
		$this->taxRuleIndex = $taxRuleIndex;
		$this->taxRuleNew = $taxRuleNew;
		$this->fixtureFactory = $fixtureFactory;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertTaxClassIsShownOnTaxClassField = $assertTaxClassIsShownOnTaxClassField;
	}

	/**
	 * @param Staff $staff
	 * @param TaxRule $taxRule
	 * @param $editTaxClassName
	 */
	public function test(
		Staff $staff,
		TaxRule $taxRule,
		$editTaxClassName
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

		// Test Case: SYNC32
		// Add New Tax Rule - Tax Class
		$taxRule->persist();

		// Reload Tax Classes
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$itemText = "Tax Classes";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();

		// Assert Tax Classes reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
		$taxClass = $taxRule->getTaxProductClass()[0];
		$this->assertTaxClassIsShownOnTaxClassField->processAssert($this->webposIndex, $taxClass , $action);


//		// Test Case: SYNC23
//		// Edit Tax Class
//		$editTaxClassName = str_replace('%isolation%', mt_rand(1, 9999999), $editTaxClassName);
//		$this->taxRuleIndex->open();
//		$this->taxRuleIndex->getTaxRuleGrid()->searchAndOpen(['code' => $taxRule->getCode()]);
//		$this->taxRuleNew->getDetailsBlock()->clickAdditionalSetting();
//		$taxClassDiv = $this->taxRuleNew->getDetailsBlock()->getProductTaxClassItem($taxClass);
//		$taxClassDiv->hover();
//		$this->taxRuleNew->getDetailsBlock()->getProductTaxClassEditButton($taxClass)->click();
//		sleep(1);
//		$this->taxRuleNew->getDetailsBlock()->getProductTaxClassInput($taxClass)->setValue($editTaxClassName);
//		$this->taxRuleNew->getDetailsBlock()->getProductTaxClassSaveButton($taxClass)->click();
//
//		// Update Tax Classes
//		$this->webposIndex->open();
//		$this->webposIndex->getMsWebpos()->clickCMenuButton();
//		$this->webposIndex->getCMenu()->synchronization();
//		sleep(1);
//		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();
//
//		// Assert Customer Complain update success
//		$action = 'Update';
//		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
//		$this->assertTaxClassIsShownOnTaxClassField->processAssert($this->webposIndex, $editTaxClassName, $action);
	}
}