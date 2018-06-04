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
	 * @var $type
	 * value: % or $
	 */
	protected $type;


	public function __construct(
		WebposIndex $webposIndex,
		$percent,
		$type = '%'
	)
	{
		$this->webposIndex = $webposIndex;
		$this->percent = $percent;
		$this->type = $type;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		$this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
		$this->webposIndex->getCheckoutContainer()->waitForCartDiscountPopup();
        sleep(1);
		if (strcmp($this->type, '%') == 0) {
			$this->webposIndex->getCheckoutDiscount()->getDiscountButton()->click();
		} else if (strcmp($this->type, '$') == 0) {
			$this->webposIndex->getCheckoutDiscount()->getDollarButton()->click();
		}

		$this->webposIndex->getCheckoutDiscount()->setDiscountAmount($this->percent);
		$this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $this->webposIndex->getCheckoutCartFooter()->waitForButtonCheckout();
	}
}