<?php
/**
 * Created by PhpStorm.
 * User: bang
 * Date: 26/01/2018
 * Time: 13:33
 */

namespace Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposOnHoldOrderONH01Test
 * @package Magento\Webpos\Test\TestCase\OnHoldOrder\CheckGUI
 * Precondition and setup steps:
 * Precondition: There is no onhold order in On-hold orders menu
 * 1. Login webpos as a staff
 * Steps:
 * 1. Click on On-hold Orders menu
 * Acceptance Criteria:
 * Show message: "You don't have any orders yet" on Order detail
 */
class WebposOnHoldOrderONH01Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
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
    }
}