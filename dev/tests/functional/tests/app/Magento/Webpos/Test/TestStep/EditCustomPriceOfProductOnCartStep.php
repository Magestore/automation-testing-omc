<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 17/01/2018
 * Time: 08:38
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class EditCustomPriceOfProductOnCartStep
 * @package Magento\Webpos\Test\TestStep
 */
class EditCustomPriceOfProductOnCartStep implements TestStepInterface
{
	/**
	 * Webpos Index page.
	 * @var WebposIndex
	 */
	protected $webposIndex;

	protected $products;

	/**
	 * AddProductToCartStep constructor.
	 * @param WebposIndex $webposIndex
	 * @param $products
	 */
	public function __construct(
		WebposIndex $webposIndex,
		$products
	)
	{
		$this->webposIndex = $webposIndex;
		$this->products = $products;
	}

	/**
	 * @return mixed|void
	 */
	public function run()
	{
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		foreach ($this->products as $item) {
			if (isset($item['customPrice'])) {
				$this->webposIndex->getCheckoutCartItems()->getCartItem($item['product']->getName())->click();
				$this->webposIndex->getCheckoutContainer()->waitForProductEditPopop();
				sleep(1);
				$this->webposIndex->getCheckoutProductEdit()->getCustomPriceButton()->click();
				sleep(1);
				$this->webposIndex->getCheckoutProductEdit()->getDollarButton()->click();
				$this->webposIndex->getCheckoutProductEdit()->getAmountInput()->setValue($item['customPrice']);
                $this->webposIndex->getMainContent()->waitForMsWebpos();
                $this->webposIndex->getMainContent()->clickOutsidePopup();
                sleep(1);
            }
		}
	}
}