<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 10/01/2018
 * Time: 09:34
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Tax\Test\Fixture\TaxRate;
use Magento\Tax\Test\Page\Adminhtml\TaxRateIndex;
use Magento\Tax\Test\Page\Adminhtml\TaxRateNew;

class EditTaxRateInBackendStep implements TestStepInterface
{
	/**
	 * Tax Rate grid page.
	 *
	 * @var TaxRateIndex
	 */
	protected $taxRateIndex;

	/**
	 * Tax Rate new/edit page.
	 *
	 * @var TaxRateNew
	 */
	protected $taxRateNew;

	/**
	 * @var TaxRate
	 */
	protected $taxRate;

	/**
	 * EditTaxRateInBackendStep constructor.
	 * @param TaxRateIndex $taxRateIndex
	 * @param TaxRateNew $taxRateNew
	 */
	public function __construct(
		TaxRateIndex $taxRateIndex,
		TaxRateNew $taxRateNew,
		TaxRate $taxRate
	) {
		$this->taxRateIndex = $taxRateIndex;
		$this->taxRateNew = $taxRateNew;
		$this->taxRate = $taxRate;
	}


	/**
	 * Run step flow
	 *
	 * @return mixed
	 */
	public function run()
	{
		// Steps
		$filter = [
			'code' => $this->taxRate->getCode(),
		];
		$this->taxRateIndex->open();
		$this->taxRateIndex->getTaxRateGrid()->searchAndOpen($filter);
		$this->taxRateNew->getTaxRateForm()->fill($this->taxRate);
		$this->taxRateNew->getFormPageActions()->save();
	}
}