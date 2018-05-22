<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 2/23/2018
 * Time: 4:34 PM
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\Search;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCustomerSearchWithoutResultCC27Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(WebposIndex $webposIndex, FixtureFactory $factory)
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $factory;
    }

    public function test()
    {
//        // Create Customer
//        $customer = $this->fixtureFactory->createByCode('customer', ['dataset' => 'customer_MI']);
//        $customer->persist();
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Select an existing customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();

        $this->webposIndex->getCheckoutChangeCustomer()->search('sdjkfhsdjkh@$@');
        sleep(1);
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();
        $this->assertFalse(
            $this->webposIndex->getCheckoutChangeCustomer()->getFirstCustomer()->isVisible(),
            'Have some customer with search key: sdjkfhsdjkh@#$@'
        );

    }
}