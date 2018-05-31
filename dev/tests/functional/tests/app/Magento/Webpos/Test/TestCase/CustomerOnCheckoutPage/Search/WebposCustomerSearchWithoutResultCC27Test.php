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

/**
 * Class WebposCustomerSearchWithoutResultCC27Test
 * @package Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\Search
 *
 * Precondition:
 * "1. Login Webpos as a staff
 * 2. Click on Add new customer icon"
 *
 * Steps:
 * "1. Enter incorrect name/email/phone on Search box
 * 2. Enter or click on Search icon"
 *
 * Acceptance:
 * 2. No results in list
 *
 */
class WebposCustomerSearchWithoutResultCC27Test extends Injectable
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
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $factory
     */
    public function __inject(WebposIndex $webposIndex, FixtureFactory $factory)
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $factory;
    }

    public function test()
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        // Select an existing customer
        $this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();

        $this->webposIndex->getCheckoutChangeCustomer()->search('sdjkfhsdjkh@$@');
        $this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();
        $this->assertFalse(
            $this->webposIndex->getCheckoutChangeCustomer()->getNoItemCustomer()->isVisible(),
            'Have some customer with search key: sdjkfhsdjkh@#$@'
        );

    }
}