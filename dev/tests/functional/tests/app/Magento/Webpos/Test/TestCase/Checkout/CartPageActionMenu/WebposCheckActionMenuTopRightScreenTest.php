<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/12/2017
 * Time: 10:42
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCheckActionMenuTopRightScreenTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CartPageActionMenu
 */
class WebposCheckActionMenuTopRightScreenTest extends Injectable
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
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Runs the scenario test case
     *
     * @return void
     */
    public function test()
    {
        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutCartHeader()->getIconActionMenu()->click();
    }
}