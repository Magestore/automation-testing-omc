<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 1/17/2018
 * Time: 8:04 AM
 */

namespace Magento\Webpos\Test\TestCase\Checkout\PaymentMethod;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposCheckoutPaymentMethodCP202
 * @package Magento\Webpos\Test\TestCase\Cart\PaymentMethod
 *
 * Precondition:
 * there is no payment method on webpos
 * 1. Login Webpos as a staff
 * 2. Add some products  to cart
 * 3. Click on [Checkout] button"
 *
 * Steps:
 * 1. Check payment section
 *
 * Acceptance:
 * "1. There is no payment method shown on payment section
 * 2. [Add payment] button is enable"
 *
 */
class WebposCheckoutPaymentMethodCP202Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     *
     * @return void
     */
    public function test($products, FixtureFactory $fixtureFactory)
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $i = 0;
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $i++;
            sleep(1);
        }

        //CategoryRepository
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();


    }
}