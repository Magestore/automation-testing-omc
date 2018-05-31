<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 14:00
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH06Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\HoldOrder
 * Precondition and setup steps:
 * 1. Login webpos as a staff
 * 2. Add some  products and select a customer to meet tax condition
 * 3. Click on [Hold] button
 * Steps:
 * 1. Click on On-Hold Orders menu
 * Acceptance Criteria:
 * "A new on-hold order is created with:
 * - On-hold order list: show customer name under  on-hold order ID
 * - On-hold detail order:
 * + Billing address, shipping adddress show billing address and shipping address of  the customer address
 * + Tax amount will be shown correctly on items table and [Tax] field
 * + Row total = Subtotal + Tax amount - discount"
 */
class WebposOnHoldOrderONH06Test extends Injectable
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
     * @param $products
     * @param Customer $customer
     * @return array
     */
    public function test($products, Customer $customer)
    {
        //Create product
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();
        $product1 = $products[0]['product'];
        $product2 = $products[1]['product'];

        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Create a on-hold-order
        //Add an exist taxable customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer->getFirstname());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        //Add some taxable products to cart
        $this->webposIndex->getCheckoutProductList()->search($product1->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $tax1 = $this->webposIndex->getCheckoutCartFooter()->getTaxWithCheckout();
        $this->webposIndex->getCheckoutProductList()->search($product2->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $tax = $this->webposIndex->getCheckoutCartFooter()->getTaxWithCheckout();
        $tax2 = $tax - $tax1;
        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(1);

        $dataProduct1 = $product1->getData();
        $dataProduct1['qty'] = '1';
        $dataProduct2 = $product2->getData();
        $dataProduct2['qty'] = '1';
        return ['products' => [$dataProduct1, $dataProduct2],
            'tax' => [$tax, $tax1, $tax2],
            'product' => $dataProduct1,
            'name' => $customer->getAddress()[0]['firstname'] . ' ' . $customer->getAddress()[0]['lastname'],
            'nameCustomer' => $customer->getFirstname() . ' ' . $customer->getLastname(),
            'address' => $customer->getAddress()[0]['city'] . ', ' . $customer->getAddress()[0]['region'] . ', ' . $customer->getAddress()[0]['postcode'] . ', US',
            'phone' => $customer->getAddress()[0]['telephone'],
        ];

    }
}