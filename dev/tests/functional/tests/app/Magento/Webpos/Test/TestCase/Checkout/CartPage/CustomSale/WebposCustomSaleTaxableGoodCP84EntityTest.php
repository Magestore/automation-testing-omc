<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 1/12/2018
 * Time: 9:15 AM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\CustomSale;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCustomSaleTaxableGoodCP84EntityTest
 * @package Magento\Webpos\Test\TestCase\Cart\CartPage\CustomSale
 *
 * Preconditions:
 * 1. LoginTest webpos by a  staff
 *
 * Steps:
 * 1. Add custom product to cart with Tax: Taxable goods
 * 2. Add a customer who satify tax
 *
 * Acceptance:
 * Customer product will be added to cart with correct tax
 *
 */
class WebposCustomSaleTaxableGoodCP84EntityTest extends Injectable
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
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return ['customer' => $customer];
    }

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
     * @param $productName
     * @param $productDescription
     */
    public function test($customer, $productName, $price, $tax)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->getCustomSaleButton()->click();
        $this->webposIndex->getCheckoutCustomSale()->getProductNameInput()->setValue($productName);
        // number field price keyboard
        $this->webposIndex->getCheckoutCustomSale()->getProductPriceInput()->setValue($price);
        $this->webposIndex->getCheckoutCustomSale()->getTaxClassItem($tax)->click();


        $this->webposIndex->getCheckoutCustomSale()->getAddToCartButton()->click();
        //CategoryRepository
//        sleep(3);
        // Change customer in cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();

        sleep(3);
    }
}