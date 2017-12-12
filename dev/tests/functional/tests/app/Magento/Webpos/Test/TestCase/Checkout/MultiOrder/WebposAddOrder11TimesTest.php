<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 07/12/2017
 * Time: 16:40
 */

namespace Magento\Webpos\Test\TestCase\Checkout\MultiOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposAddOrder11TimesTest
 * @package Magento\Webpos\Test\TestCase\Checkout\MultiOrder
 */
class WebposAddOrder11TimesTest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     * @return void
        $this->webposIndex->open();
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->fill($staff);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            sleep(5);
            while ($this->webposIndex->getFirstScreen()->isVisible()) {
            }
            sleep(2);
        }
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login Webpos group test.
     *
     * @param Staff $staff
     * @return void
     */
    public function test(Staff $staff)
    {
        $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep',
            ['staff' => $staff]
        )->run();
        for ($i=1; $i<=11; $i++) {
            $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
            $this->webposIndex->getCheckoutPlaceOrder()->waitCartLoader();
            self::assertTrue(
                $this->webposIndex->getCheckoutCartHeader()->getMultiOrderItem($i)->isVisible(),
                'On the Webpos Cart, The multi order item '.$i.' were visible successfully.'
            );
        }
    }
}