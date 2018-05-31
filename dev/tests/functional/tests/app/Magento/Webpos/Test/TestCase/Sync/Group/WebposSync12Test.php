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
 * Class WebposSync12Test
 * @package Magento\Webpos\Test\TestCase\Sync\Group
 */
class WebposSync12Test extends Injectable
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
     * @var AssertSynchronizationPageDisplay
     */
    protected $assertSynchronizationPageDisplay;
    protected $assertItemUpdateSuccess;

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
     *
     * @return void
     */
    public function test(
        Customer $initialCustomer
    )
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $initialCustomer->persist();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowReloadButton("Group")->click();
        sleep(5);
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Group", $action);
    }

}