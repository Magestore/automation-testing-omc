<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/10/2017
 * Time: 15:58
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\Product\AssertProductIsInProductList;
use Magento\Webpos\Test\Constraint\Synchronization\Product\AssertProductUpdateSuccess;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationProductTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * Product page with a grid.
	 *
	 * @var CatalogProductIndex
	 */
	protected $productGrid;

	/**
	 * Page to update a product.
	 *
	 * @var CatalogProductEdit
	 */
	protected $editProductPage;

	/**
	 * @var AssertProductUpdateSuccess
	 */
	protected $assertProductUpdateSuccess;

	/**
	 * @var AssertProductIsInProductList
	 */
	protected $assertProductIsInProductList;

	public function __inject(
		WebposIndex $webposIndex,
		CatalogProductIndex $productGrid,
		CatalogProductEdit $editProductPage,
		AssertProductUpdateSuccess $assertProductUpdateSuccess,
		AssertProductIsInProductList $assertProductIsInProductList
	)
	{
		$this->webposIndex = $webposIndex;
		$this->productGrid = $productGrid;
		$this->editProductPage = $editProductPage;
		$this->assertProductUpdateSuccess = $assertProductUpdateSuccess;
		$this->assertProductIsInProductList = $assertProductIsInProductList;
	}

	public function test(
		Staff $staff,
		CatalogProductSimple $product,
		CatalogProductSimple $editProduct
	)
	{
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

		// Create New Product
		$product->persist();

		// Reload Product
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$productText = "Product";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($productText)->click();

		// Assert product reload success
		$action = 'Reload';
		$this->assertProductUpdateSuccess->processAssert($this->webposIndex, $action);
		$this->assertProductIsInProductList->processAssert($this->webposIndex, $product, $action);


		// Edit Product
		$filter = ['sku' => $product->getSku()];

		$this->productGrid->open();
		$this->productGrid->getProductGrid()->searchAndOpen($filter);
		$this->editProductPage->getProductForm()->fill($editProduct);
		$this->editProductPage->getFormPageActions()->save();

		// Update Product
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($productText)->click();

		// Assert product update success
		$action = 'Update';
		$this->assertProductUpdateSuccess->processAssert($this->webposIndex, $action);
		$this->assertProductIsInProductList->processAssert($this->webposIndex, $editProduct, $action);
	}
}