<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/26/2018
 * Time: 9:27 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\SwatchOption;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndexEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Sync\AssertSynchronizationPageDisplay;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSync07Test
 * @package Magento\Webpos\Test\TestCase\Sync\SwatchOption
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 * 2. Login backend on another browser > Change color or size attribute of child item of Config product
 * 3. Back to  the browser which are opening webpos
 *
 * Steps
 * 1. Go to Synchronization page
 * 2. Reload Swatch option
 *
 * Acceptance Criteria
 * 2. Swatch option will be updated and shown on child item of the config product that just changed
 */
class WebposSync07Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * Customer grid page.
     *
     * @var CustomerIndex $customerIndexPage
     */
    protected $customerIndexPage;

    /**
     * Customer edit page.
     *
     * @var CustomerIndexEdit $customerIndexEditPage
     */
    protected $customerIndexEditPage;

    /**
     * Product page with a grid.
     *
     * @var CatalogProductIndex $productGrid
     */
    protected $productGrid;

    /**
     * Page to update a product.
     *
     * @var CatalogProductEdit $editProductPage
     */
    protected $editProductPage;

    /**
     * @var AssertSynchronizationPageDisplay $assertSynchronizationPageDisplay
     */
    protected $assertSynchronizationPageDisplay;
    /**
     * @var AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    /**
     * @param WebposIndex $webposIndex
     * @param CustomerIndex $customerIndexPage
     * @param CustomerIndexEdit $customerIndexEditPage
     * @param CatalogProductIndex $productGrid
     * @param CatalogProductEdit $editProductPage
     * @param AssertSynchronizationPageDisplay $assertSynchronizationPageDisplay
     * @param AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    public function __inject(
        WebposIndex $webposIndex,
        CustomerIndex $customerIndexPage,
        CustomerIndexEdit $customerIndexEditPage,
        CatalogProductIndex $productGrid,
        CatalogProductEdit $editProductPage,
        AssertSynchronizationPageDisplay $assertSynchronizationPageDisplay,
        AssertItemUpdateSuccess $assertItemUpdateSuccess
    )
    {
        $this->webposIndex = $webposIndex;
        $this->customerIndexPage = $customerIndexPage;
        $this->customerIndexEditPage = $customerIndexEditPage;
        $this->productGrid = $productGrid;
        $this->editProductPage = $editProductPage;
        $this->assertSynchronizationPageDisplay = $assertSynchronizationPageDisplay;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
    }

    /**
     * @param FixtureFactory $fixtureFactory
     * @param Customer $initialCustomer
     * @param Customer $customer
     * @param CatalogProductSimple $initialProduct
     * @param CatalogProductSimple $product
     * @param $products
     */
    public function test(
        FixtureFactory $fixtureFactory,
        Customer $initialCustomer,
        Customer $customer,
        CatalogProductSimple $initialProduct,
        CatalogProductSimple $product,
        $products
    )
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $initialCustomer->persist();
        $initialProduct->persist();
        // Edit Created Product in backend
        $filter = ['sku' => $initialProduct->getSku()];
        $this->productGrid->open();
        $this->productGrid->getProductGrid()->searchAndOpen($filter);
        $this->editProductPage->getProductForm()->fill($product);
        $this->editProductPage->getFormPageActions()->save();

        // Edit Created Customer in backend
        $filter = ['email' => $initialCustomer->getEmail()];
        $this->customerIndexPage->open();
        $this->customerIndexPage->getCustomerGridBlock()->searchAndOpen($filter);
        $this->customerIndexEditPage->getCustomerForm()->updateCustomer($customer);
        $this->customerIndexEditPage->getPageActionsBlock()->save();

        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowUpdateButton("Swatch Option")->click();
        sleep(5);
        $action = 'Update';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Swatch Option", $action);
    }
}