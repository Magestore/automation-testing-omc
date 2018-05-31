<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 1/26/2018
 * Time: 3:34 PM
 */

namespace Magento\Webpos\Test\TestCase\OrdersHistory\MassActionReOrder;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposMassActionReOrderOH29Test
 * @package Magento\Webpos\Test\TestCase\OrdersHistory\MassActionReOrder
 */
class WebposMassActionReOrderOH29Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory $fixtureFactory
     */
    protected $fixtureFactory;

    protected $defaultPaymentMethod;

    /**
     * Prepare data.
     *
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        // Change TaxRate
        $taxRate = $fixtureFactory->createByCode('taxRate', ['dataset' => 'US-MI-Rate_1']);
        $this->objectManager->create('Magento\Tax\Test\Handler\TaxRate\Curl')->persist($taxRate);

        // Add Customer
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();

        return [
            'customer' => $customer,
            'taxRate' => $taxRate->getRate()
        ];
    }

    /**
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * @param Customer $customer
     * @param $products
     * @param $configData
     * @param $taxRate
     * @param bool $addDiscount
     * @param null $discountAmount
     * @param $dataConfigPayment
     * @param $defaultPaymentMethod
     * @return array
     */
    public function test(
        Customer $customer,
        $products,
        $configData,
        $taxRate,
        $addDiscount = false,
        $discountAmount = null,
        $dataConfigPayment,
        $defaultPaymentMethod
    )
    {
        //Config Customer Credit Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $dataConfigPayment]
        )->run();

        // Create products
        $products = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductsStep',
            ['products' => $products]
        )->run();

        // Config Tax
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $configData]
        )->run();

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Add product to cart
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\AddProductToCartStep',
            ['products' => $products]
        )->run();

        // change customer
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();
        sleep(2);
        // Add Discount
        if ($addDiscount) {
            $this->webposIndex->getCheckoutCartFooter()->getAddDiscount()->click();
            sleep(1);
            self::assertTrue(
                $this->webposIndex->getCheckoutDiscount()->isVisible(),
                'CategoryRepository - TaxClass page - Delete TaxClass - Add discount popup is not shown'
            );
            $this->webposIndex->getCheckoutDiscount()->setDiscountPercent($discountAmount);
            $this->webposIndex->getCheckoutDiscount()->clickDiscountApplyButton();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        }

        // Place order
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(3);
        // Select Payment Method
        $this->webposIndex->getCheckoutPaymentMethod()->getCustomPayment2()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        sleep(2);
        $this->webposIndex->getCheckoutPlaceOrder()->getButtonPlaceOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        // End Place Order

        $this->webposIndex->getCheckoutSuccess()->getNewOrderButton()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->ordersHistory();
        $this->webposIndex->getMsWebpos()->waitOrdersHistoryVisible();
        $this->webposIndex->getOrderHistoryOrderList()->waitLoader();
        $this->webposIndex->getOrderHistoryOrderList()->waitOrderListIsVisible();

        $this->webposIndex->getOrderHistoryOrderList()->getFirstOrder()->click();

        $this->webposIndex->getOrderHistoryOrderViewHeader()->openAddOrderNote();
        $this->webposIndex->getOrderHistoryOrderViewHeader()->getAction('Re-order')->click();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->defaultPaymentMethod = $defaultPaymentMethod;
        return [
            'products' => $products,
            'taxRate' => $taxRate
        ];
    }

    public function tearDown()
    {
        //Config Payment Payment Method
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => $this->defaultPaymentMethod]
        )->run();
    }
}