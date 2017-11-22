<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 27/10/2017
 * Time: 09:14
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;

use Magento\Catalog\Test\Fixture\Category;
use Magento\Catalog\Test\Page\Adminhtml\CatalogCategoryEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogCategoryIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Synchronization\Category\AssertCategoryIsInCategoryList;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSynchronizationCategoryTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	/**
	 * Catalog category index page
	 *
	 * @var CatalogCategoryIndex
	 */
	protected $catalogCategoryIndex;

	/**
	 * Catalog category edit page
	 *
	 * @var CatalogCategoryEdit
	 */
	protected $catalogCategoryEdit;

	/**
	 * Fixture Factory.
	 *
	 * @var FixtureFactory
	 */
	protected $fixtureFactory;

	/**
	 * @var AssertItemUpdateSuccess
	 */
	protected $assertItemUpdateSuccess;

	/**
	 * @var AssertCategoryIsInCategoryList
	 */
	protected $assertCategoryIsInCategoryList;

	/**
	 * @var Category
	 */
	protected $category;

	public function __inject(
		WebposIndex $webposIndex,
		CatalogCategoryIndex $catalogCategoryIndex,
		CatalogCategoryEdit $catalogCategoryEdit,
		FixtureFactory $fixtureFactory,
		AssertItemUpdateSuccess $assertItemUpdateSuccess,
		AssertCategoryIsInCategoryList $assertCategoryIsInCategoryList
	)
	{
		$this->webposIndex = $webposIndex;
		$this->fixtureFactory = $fixtureFactory;
		$this->catalogCategoryIndex = $catalogCategoryIndex;
		$this->catalogCategoryEdit = $catalogCategoryEdit;
		$this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
		$this->assertCategoryIsInCategoryList = $assertCategoryIsInCategoryList;
	}

	public function test(
		Staff $staff,
		Category $category,
		Category $editCategory
	)
	{
		$this->category = $category;
		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {}
			sleep(2);
		}

		// Add new category
		$category->persist();

		// Reload Category
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$categoryText = "Category";
		$this->webposIndex->getSynchronization()->getItemRowReloadButton($categoryText)->click();

		// Assert category reload success
		$action = 'Reload';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $categoryText, $action);
		$this->assertCategoryIsInCategoryList->processAssert($this->webposIndex, $category, $action);

		// Edit Category
		$this->catalogCategoryEdit->open(['id' => $category->getId()]);
		$this->catalogCategoryEdit->getEditForm()->fill($editCategory);
		$this->catalogCategoryEdit->getFormPageActions()->save();

		// Update Category
		$this->webposIndex->open();
		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->synchronization();
		sleep(1);
		$this->webposIndex->getSynchronization()->getItemRowUpdateButton($categoryText)->click();

		// Assert category update success
		$action = 'Update';
		$this->assertItemUpdateSuccess->processAssert($this->webposIndex, $categoryText, $action);

		$this->category = $this->prepareCategory($editCategory, $category);
		return [
			'category' => $this->category,
			'action' => $action
		];

	}

	/**
	 * Prepare Category fixture with the updated data.
	 *
	 * @param Category $category
	 * @param Category $initialCategory
	 * @return Category
	 */
	protected function prepareCategory(Category $category, Category $initialCategory)
	{
		$parentCategory = $category->hasData('parent_id')
			? $category->getDataFieldConfig('parent_id')['source']->getParentCategory()
			: $initialCategory->getDataFieldConfig('parent_id')['source']->getParentCategory();

		$data = [
			'data' => array_merge(
				$initialCategory->getData(),
				$category->getData(),
				['parent_id' => ['source' => $parentCategory]]
			)
		];

		return $this->fixtureFactory->createByCode('category', $data);
	}

	public function tearDown()
	{
		$this->catalogCategoryEdit->open(['id' => $this->category->getId()]);
		$this->catalogCategoryEdit->getFormPageActions()->delete();
		$this->catalogCategoryEdit->getModalBlock()->acceptAlert();
	}
}