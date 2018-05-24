<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 13/12/2017
 * Time: 13:21
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\EditQty;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty\AssertEditProductPopupIsAvailable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCheckoutCartEditQtyCheckoutByEditQtyProductTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\EditQty
 */
class WebposCheckoutCartEditQtyCheckoutByEditQtyProductTest extends Injectable
{
	/**
	 * @var WebposIndex $webposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertEditProductPopupIsAvailable $assertEditProductPopupIsAvailable
	 */
	protected $assertEditProductPopupIsAvailable;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertEditProductPopupIsAvailable $assertEditProductPopupIsAvailable
     */
	public function __inject(
		WebposIndex $webposIndex,
		AssertEditProductPopupIsAvailable $assertEditProductPopupIsAvailable
	)
	{
		$this->webposIndex = $webposIndex;
		$this->assertEditProductPopupIsAvailable = $assertEditProductPopupIsAvailable;
	}

    /**
     * @param CatalogProductSimple $product
     * @param $qty
     * @param $qtyInput
     */
	public function test(
		CatalogProductSimple $product,
		$qty,
		$qtyInput
	)
	{
		// LoginTest webpos
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
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(1);

		$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

		$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
		$this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
	}
}