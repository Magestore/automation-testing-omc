<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 24/01/2018
 * Time: 10:17
 */

namespace Magento\Webpos\Test\TestStep;


use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class AddDiscountWholeCartStep
 * @package Magento\Webpos\Test\TestStep
 */
class AddDiscountWholeCartStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var $percent
	 */
	protected $percent;


	/**
	 * AddDiscountWholeCartStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $percent
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$percent
	)
	{
		$this->webposIndex = $webposIndex;
		$this->percent = $percent;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		$this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
		$this->webposIndex->getCheckoutContainer()->waitForCartDiscountPopup();

		$this->webposIndex->getCheckoutDiscount()->setDiscountPercent($this->percent);
		$this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

	}
}