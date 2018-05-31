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
 * Class WebposSync14Test
 * @package Magento\Webpos\Test\TestCase\Sync\CustomerComplaints
 * Precondition and setup steps
 * 1. Login Webpos as a staff
 * 2. Goto Database on another browser  > Webpos_customer_complaints table > Add a new complaint for any customer
 * 3. Back to  the browser which are opening webpos
 *
 * Steps
 * 1. Go to synchronization page
 * 2. Reload customer complaints
 *
 * Acceptance Criteria
 * 2. Complaint just added will be shown on corresponding customer detail page
 */
class WebposSync14Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

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
     * @param Customer $customer
     * @param CustomerComplain $customerComplain
     */
    public function test(
        Customer $customer,
        CustomerComplain $customerComplain
    )
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

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

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();

        $this->webposIndex->getSyncTabData()->waitItemRowReloadButton("Customer Complaints");
        $this->webposIndex->getSyncTabData()->getItemRowReloadButton("Customer Complaints")->click();
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Customer Complaints", $action);
    }

}