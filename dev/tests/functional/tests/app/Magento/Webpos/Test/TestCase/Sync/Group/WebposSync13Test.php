<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/26/2018
 * Time: 9:27 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\Group;

use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndexEdit;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Sync\AssertSynchronizationPageDisplay;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSync13Test
 * @package Magento\Webpos\Test\TestCase\Sync\Group
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 * 2. Login backend on another browser  > Customer groups > Edit a customer group (name)
 * 3. Back to  the browser which are opening webpos
 *
 * Steps
 * 1. Go to synchronization page
 * 2. Update group
 *
 * Acceptance Criteria
 * 2. The customer group will be updated and shown on Create/Edit customer popup
 */
class WebposSync13Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * Customer grid page.
     *
     * @var CustomerIndex
     */
    protected $customerIndexPage;

    /**
     * Customer edit page.
     *
     * @var CustomerIndexEdit
     */
    protected $customerIndexEditPage;

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
     * @var AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    /**
     * @var AssertSynchronizationPageDisplay
     */
    protected $assertSynchronizationPageDisplay;

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
     * @param Customer $initialCustomer
     * @param Customer $customer
     */
    public function test(
        Customer $initialCustomer,
        Customer $customer
    )
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $initialCustomer->persist();

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
        $this->webposIndex->getSyncTabData()->getItemRowUpdateButton("Group")->click();
        sleep(5);
        $action = 'Update';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Group", $action);
    }
}