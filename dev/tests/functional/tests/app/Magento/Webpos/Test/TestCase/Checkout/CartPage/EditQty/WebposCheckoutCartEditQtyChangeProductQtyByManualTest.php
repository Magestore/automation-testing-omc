<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 13/12/2017
 * Time: 10:49
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\EditQty;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty\AssertEditProductPopupIsAvailable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckoutCartEditQtyChangeProductQtyByManualTest
 *
 * Pre: "1. Login webpos by a  staff
2. Add a product to cart with qty = 1"
 * Step: "1. Click on name or image of a product in cart
2. Input special symbols or text to qty textbox
Ex: #$^&* or abc
3. Click Enter"
 * Expect: Show message: "Warning: The fewest you may purchase is 1"
 *
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\EditQty
 */
class WebposCheckoutCartEditQtyChangeProductQtyByManualTest extends Injectable
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
		$qtyInput
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

		$this->webposIndex->getCheckoutProductEdit()->getQtyInput()->setValue($qtyInput);
	}
}