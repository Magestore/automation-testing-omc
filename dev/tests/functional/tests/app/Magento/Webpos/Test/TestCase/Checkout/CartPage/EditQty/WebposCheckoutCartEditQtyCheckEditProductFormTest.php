<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 13:33
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\EditQty;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CartPage\EditQty\AssertEditProductPopupIsAvailable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCheckoutCartEditQtyCheckEditProductFormTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\EditQty
 */
class WebposCheckoutCartEditQtyCheckEditProductFormTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var AssertEditProductPopupIsAvailable
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
     */
	public function test(
		CatalogProductSimple $product
	)
	{
		// LoginTest webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		$this->webposIndex->getCheckoutProductList()->search($product->getName());
		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		//Click on product in cart
		$this->webposIndex->getCheckoutCartItems()->getCartItem($product->getName())->click();
		// CP45
		//Assert edit product popup is available
        $this->webposIndex->getCheckoutProductEdit()->getClosePopupCustomerSale()->click();
        sleep(1);

//      $this->assertEditProductPopupIsAvailable->processAssert($this->webposIndex);
//		$this->webposIndex->getCheckoutProductEdit()->getCancelButton()->click();
	}
}