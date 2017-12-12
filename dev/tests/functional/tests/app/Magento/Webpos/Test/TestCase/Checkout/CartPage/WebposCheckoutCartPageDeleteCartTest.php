<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 04/12/2017
 * Time: 13:25
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCheckoutCartPageDeleteCartTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		Staff $staff,
		CatalogProductSimple $product,
		$addProduct = true,
		$customSale = false,
		$customProduct = null,
		$addDiscount = false,
		$discountAmount = null
	)
	{
		$this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep',
			['staff' => $staff]
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

		if ($addProduct) {
			if (!$customSale) {
				$this->webposIndex->getCheckoutProductList()->search($product->getName());
				$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
			} else {
				$random = mt_rand(1, 999999);
				$customProduct['name'] = str_replace('%isolation%', $random, $customProduct['name']);
				$customProduct['description'] = str_replace('%isolation%', $random, $customProduct['description']);

				$this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();

				$this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($customProduct['name']);
				$this->webposIndex->getCheckoutCustomSale()->getDescriptionInput()->setValue($customProduct['description']);
				$this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($customProduct['price']);
				$this->webposIndex->getCheckoutCustomSale()->getShipAbleCheckbox()->click();

				$this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
				$this->webposIndex->getMsWebpos()->waitCartLoader();
				$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
			}
		}

		if ($addDiscount) {
			$this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
			sleep(1);
			self::assertTrue(
				$this->webposIndex->getCheckoutDiscount()->isVisible(),
				'Checkout - Cart page - Delete Cart - Add discount popup is not shown'
			);
			$this->webposIndex->getCheckoutDiscount()->setDiscountPercent($discountAmount);
			$this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
			$this->webposIndex->getMsWebpos()->waitCartLoader();
			$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
		}

		sleep(1);
		$this->webposIndex->getCheckoutCartHeader()->getIconDeleteCart()->click();
		$this->webposIndex->getMsWebpos()->waitCartLoader();
		$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
	}
}