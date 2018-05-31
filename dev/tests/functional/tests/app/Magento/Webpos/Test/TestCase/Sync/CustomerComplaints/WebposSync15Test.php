<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/1/2018
 * Time: 8:10 AM
 */

namespace Magento\Webpos\Test\TestCase\Sync\CustomerComplaints;

use Magento\Catalog\Test\Page\Adminhtml\CatalogProductEdit;
use Magento\Catalog\Test\Page\Adminhtml\CatalogProductIndex;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndex;
use Magento\Customer\Test\Page\Adminhtml\CustomerIndexEdit;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
use Magento\Webpos\Test\Constraint\Sync\AssertSynchronizationPageDisplay;
use Magento\Webpos\Test\Fixture\CustomerComplain;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposSync15Test
 * @package Magento\Webpos\Test\TestCase\Sync\CustomerComplaints
 */
class WebposSync15Test extends Injectable
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
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

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
     * @param FixtureFactory $fixtureFactory
     * @param AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
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
     * @param FixtureFactory $fixtureFactory
     * @param Customer $customer
     * @param CustomerComplain $customerComplain
     * @param CustomerComplain $editCustomerComplain
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