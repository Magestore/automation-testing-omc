<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:26
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\Search;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH27Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\Search
 * Precondition and setup steps:
 * 1. Login Webpos as a staff
 * 2. Create an on-hold order successfully
 * Steps:
 * 1. Go to on-hold order page
 * 2. Enter correct customer name into box search
 * 3. Click on Search icon
 * Acceptance Criteria:
 * On-hold order list shows the orders has customer name matchs or contains keyword
 */
class WebposOnHoldOrderONH27Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'webpos_default_guest_checkout_rollback']
        )->run();

        //Create customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'webpos_guest_pi']);
        $customer->persist();
        return ['customer' => $customer];
    }

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @return array
     */
    public function test(Customer $customer, $products)
    {
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create a on-hold-order
        //Add an exist customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getFirstname());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        //Add a product to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        //Go to on-hold order page
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->onHoldOrders();
        sleep(1);

        //Enter incorrect customer name/order id into box search
        $this->webposIndex->getOnHoldOrderOrderList()->getSearchOrderInput()->setValue(strtolower($customer->getFirstname()));
        sleep(1);

        //Enter or click on Search icon
        $this->webposIndex->getOnHoldOrderOrderList()->getIconSearch()->click();
        $this->webposIndex->getOnHoldOrderOrderList()->waitLoader();
        sleep(1);

        return ['result' => 'customer',
            'input' => $customer->getFirstname()];
    }
}