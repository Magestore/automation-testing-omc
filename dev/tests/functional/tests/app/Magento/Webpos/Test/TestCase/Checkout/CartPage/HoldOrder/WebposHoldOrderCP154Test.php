<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 18/01/2018
 * Time: 13:21
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposHoldOrderCP154Test
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPage\HoldOrder
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * Click on [Hold] button
 *
 * Acceptance:
 * Show message "Warning: Please add item(s) to cart!"
 *
 */
class WebposHoldOrderCP154Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject
    (
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        //LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        //Hold
        $this->webposIndex->getCheckoutCartFooter()->getButtonHold()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        $warningMessage = $this->webposIndex->getToaster()->getWarningMessage()->getText();

        return ['warningMessageActual' => $warningMessage];
    }
}