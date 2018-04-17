<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/26/2018
 * Time: 9:27 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\Product;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndexEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Sync\AssertSynchronizationPageDisplay;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposSync11Test extends Injectable
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
    /**
     * @var AssertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        // Add Customer
//        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
//        $customer->persist();
//
//        return [
//            'customer' => $customer
//        ];
    }

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

        $initialProduct->persist();

        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // Edit Created Product in backend
        $filter = ['sku' => $initialProduct->getSku()];
        $this->productGrid->open();
        $this->productGrid->getProductGrid()->searchAndOpen($filter);
        $this->editProductPage->getProductForm()->fill($product);
        $this->editProductPage->getFormPageActions()->save();

        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowUpdateButton("Product")->click();
        sleep(5);
        $action = 'Update';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Product", $action);
    }

    public function tearDown()
    {
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'default_payment_method']
//        )->run();
    }

}