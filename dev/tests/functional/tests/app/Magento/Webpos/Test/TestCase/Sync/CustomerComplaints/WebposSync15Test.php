<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/1/2018
 * Time: 8:10 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\CustomerComplaints;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Customer\Test\Fixture\Address;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Webpos\Test\Fixture\CustomerComplain;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndexEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Sync\AssertSynchronizationPageDisplay;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;

class WebposSync15Test extends Injectable
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
        FixtureFactory $fixtureFactory,
        AssertItemUpdateSuccess $assertItemUpdateSuccess

    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;

    }

    /**
     *
     * @return void
     */
    public function test(
        FixtureFactory $fixtureFactory,
        Customer $customer,
        CustomerComplain $customerComplain,
        CustomerComplain $editCustomerComplain
    )
    {
        // Add new customer complain
        $customerComplain = $this->fixtureFactory->createByCode(
            'customerComplain',
            [
                'data' => array_merge(
                    $customerComplain->getData(),
                    ['customer_email' => $customer->getEmail()]
                )
            ]
        );
        $customerComplain->persist();
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();



        // Edit Customer Complain
        $customerComplain = $this->prepareCustomerComplain($editCustomerComplain, $customerComplain);
        $customerComplain->persist();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowUpdateButton("Customer Complaints")->click();
        sleep(5);
        $action = 'Update';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Customer Complaints", $action);
    }

    public function tearDown()
    {
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'default_payment_method']
//        )->run();
    }

    protected function prepareCustomerComplain(CustomerComplain $customerComplain, CustomerComplain $initialCustomerComplain)
    {
        $data = [
            'data' => array_merge(
                $initialCustomerComplain->getData(),
                $customerComplain->getData()
            )
        ];

        return $this->fixtureFactory->createByCode('customerComplain', $data);
    }
}