<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 16:40
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposAddOrder11TimesTest
 * @package Magento\AssertWebposCheckGUICustomerPriceCP54\Test\TestCase\CategoryRepository\MultiOrder
 */
class WebposAddOrder11TimesTest extends Injectable
{
    /**
     * AssertWebposCheckGUICustomerPriceCP54 Index page.
     *
     * @var WebposIndex
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
     * Login AssertWebposCheckGUICustomerPriceCP54 group test.
     *
     * @return void
     */
    public function test()
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        for ($i=1; $i<=11; $i++) {
            $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            self::assertTrue(
                $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->isVisible(),
                'On the AssertWebposCheckGUICustomerPriceCP54 TaxClass, The multi order item '.$i.' were not visible successfully.'
            );
        }
    }
}