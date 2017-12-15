<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 12/12/2017
 * Time: 13:22
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\EditQty;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty\AssertEditProductPopupIsAvailable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCheckoutCartEditQtyChangeProductQtyTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertEditProductPopupIsAvailable
	 */
	protected $assertEditProductPopupIsAvailable;

	public function __inject(
		WebposIndex $webposIndex,
		AssertEditProductPopupIsAvailable $assertEditProductPopupIsAvailable
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertEditProductPopupIsAvailable = $assertEditProductPopupIsAvailable;
	}

	public function test(
		CatalogProductSimple $product,
		$qty,
		$expectQty,
		$action
	)
	{
		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		for ($i = 0; $i < $qty; $i++) {
			$this->webposIndex->getCheckoutProductList()->search($product->getName());
			$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
			$this->webposIndex->getMsWebpos()->waitCartLoader();
		}

		//Click on product in cart
		$this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();

		// CP45
		//Assert edit product popup is available
		$this->assertEditProductPopupIsAvailable->processAssert($this->webposIndex);

		if (strcmp($action, '-') == 0) {
			$this->webposIndex->getCheckoutProductEdit()->getDescQtyButton()->click();
		} elseif (strcmp($action, '+') == 0) {
			$this->webposIndex->getCheckoutProductEdit()->getIncQtyButton()->click();
		}
	}
}