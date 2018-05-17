<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/28/2018
 * Time: 9:35 AM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\UseGuest;

use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;


/**
 * Class WebposCustomerOnCheckoutPageCC26Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\UseGuest
 */
class WebposCustomerOnCheckoutPageCC26Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @param FixtureFactory $fixtureFactory
     * @return array
     */
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $customer = $fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
        $customer->persist();
        return [
            'customer' => $customer
        ];
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
     * @param Customer $customer
     */
    public function test(
        Customer $customer
    )
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Change customer in cart meet Michigan Tax
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\ChangeCustomerOnCartStep',
            ['customer' => $customer]
        )->run();

        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();
        $this->webposIndex->getCheckoutChangeCustomer()->getUseGuestButton()->click();
    }
}