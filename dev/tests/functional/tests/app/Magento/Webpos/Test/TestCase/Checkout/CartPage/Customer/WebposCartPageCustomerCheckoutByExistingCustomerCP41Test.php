<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 11/12/2017
 * Time: 07:58
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\Customer;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCartPageCustomerCheckoutByExistingCustomerCP41Test
 * @package Magento\Webpos\Test\TestCase\CategoryRepository\CartPage\Customer
 *
 * Precondition:
 * 1. Login webpos by a  staff
 * 2. Add some products  to cart
 * 3. Select an existing customer
 *
 * Steps:
 * "1.Click on icon to change customer
 * 2. Select a different customer
 *
 * Acceptance:
 * Customer on cart page was changed
 */
class WebposCartPageCustomerCheckoutByExistingCustomerCP41Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param CatalogProductSimple $product
     * @param Customer $customer1
     * @param Customer $customer2
     * @return array
     */
    public function test(
        CatalogProductSimple $product,
        Customer $customer1,
        Customer $customer2
    )
    {
        //Prepare customers
        $customer1->persist();
        $customer2->persist();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->search($product->getName());
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Select an existing customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        self::assertTrue(
            $this->webposIndex->getCheckoutChangeCustomer()->isVisible(),
            'CategoryRepository - TaxClass Page - Change customer popup is not shown'
        );
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer1->getEmail());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);

        // Select a different customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        self::assertTrue(
            $this->webposIndex->getCheckoutChangeCustomer()->isVisible(),
            'CategoryRepository - TaxClass Page - Change customer popup is not shown'
        );
        $this->webposIndex->getCheckoutChangeCustomer()->search($customer2->getEmail());
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->click();
        sleep(1);

        return ['customer' => $customer2];
    }
}