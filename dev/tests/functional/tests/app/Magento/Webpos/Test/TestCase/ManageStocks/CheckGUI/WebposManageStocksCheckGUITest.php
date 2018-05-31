<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/03/2018
 * Time: 08:53
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\CheckGUI;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/***
 * Check GUI
 * Testcase MSK01 - Check GUI
 *
 * Precondition
 * 1. Login Webpos as a staff
 * 2. Click to show left menu
 *
 * Steps
 * 1. Click on menu Manage Stocks
 *
 * Acceptance Criteria
 * 1. Display Manage Stock page includding:
 * - List of  products with name,sku and Qty
 * - Text field: Qty be able edit
 * - Swich case: In stock, Manage stock, Backorders
 * - Action clolum: update
 *
 * Class WebposManageStocksCheckGUITest
 * @package Magento\Webpos\Test\TestCase\ManageStocks\CheckGUI
 */
class WebposManageStocksCheckGUITest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->manageStocks();
        sleep(2);

    }
}