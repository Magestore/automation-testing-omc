<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/03/2018
 * Time: 08:22
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Checkout\CheckGUI\AssertWebposCheckoutPagePlaceOrderPageSuccessVisible;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksUpdateProductAttributesTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	public function __inject(
		WebposIndex $webposIndex,
		FixtureFactory $fixtureFactory
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
	}

	public function test(
		$productInfo,
		$action = '',
		$placeOrder = false
	)
	{
		// Create product

		$productInfo['product'] = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\CreateNewProductByCurlStep',
			[
				'productData' => $productInfo['product']
			]
		)->run();

		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(2);

		$productName = $productInfo['product']->getName();

		// Edit product info
		$this->webposIndex->getManageStockList()->searchProduct($productName);
		$this->webposIndex->getManageStockList()->getStoreAddress()->click();
		sleep(1);

		if (isset($productInfo['qty'])) {
			$this->webposIndex->getManageStockList()->getProductQtyInput($productName)->setValue($productInfo['qty']);
		}
		if (isset($productInfo['inStock'])) {
			$inStockCheckbox = $this->webposIndex->getManageStockList()->getProductInStockCheckbox($productName);
			$this->webposIndex->getManageStockList()->setCheckboxValue($inStockCheckbox, $productInfo['inStock']);
		}
		if (isset($productInfo['manageStock'])) {
			$manageStockCheckbox = $this->webposIndex->getManageStockList()->getProductManageStocksCheckbox($productName);
			$this->webposIndex->getManageStockList()->setCheckboxValue($manageStockCheckbox, $productInfo['manageStock']);
		}
		if (isset($productInfo['backorders'])) {
			$backordersCheckbox = $this->webposIndex->getManageStockList()->getProductBackOrdersCheckbox($productName);
			$this->webposIndex->getManageStockList()->setCheckboxValue($backordersCheckbox, $productInfo['backorders']);
		}

		// action
		if ($action === 'update') {
			$this->webposIndex->getManageStockList()->getUpdateButton($productName)->click();
			$this->webposIndex->getManageStockList()->waitForProductIconSuccess($productName);
		}

		if (isset($productInfo['orderQty'])) {
			// Open checkout page
			$this->webposIndex->getMsWebpos()->clickCMenuButton();
			$this->webposIndex->getCMenu()->checkout();
			$this->webposIndex->getCheckoutCartFooter()->waitButtonHoldVisible();
			$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

			// Add product to cart
			for ($i = 0; $i < $productInfo['orderQty']; $i++) {
				$this->webposIndex->getCheckoutProductList()->search($productInfo['product']->getSku());
				$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
				$this->webposIndex->getMsWebpos()->waitCartLoader();
			}

			if ($placeOrder) {
				$this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
				$this->webposIndex->getMsWebpos()->waitCartLoader();
				$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
				sleep(2);
				$this->webposIndex->getCheckoutPaymentMethod()->getCashInMethod()->click();
				$this->webposIndex->getMsWebpos()->waitCheckoutLoader();

				$this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
				$this->webposIndex->getMsWebpos()->waitCheckoutLoader();
			}
		}

		return [
			'productInfo' => $productInfo
		];
	}
}