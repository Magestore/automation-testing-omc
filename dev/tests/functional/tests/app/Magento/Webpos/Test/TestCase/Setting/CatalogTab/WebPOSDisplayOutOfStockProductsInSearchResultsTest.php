<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 16:07
 */

namespace Magento\Webpos\Test\TestCase\Setting\CatalogTab;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSDisplayOutOfStockProductsInSearchResultsTest
 * @package Magento\Webpos\Test\TestCase\Setting\CatalogTab
 */
class WebPOSDisplayOutOfStockProductsInSearchResultsTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    protected $productName;
    protected $menuItem;
    protected $option;
    protected $testCaseID;

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
     * @param $productName
     * @param $menuItem
     * @param $option
     * @param $successMessage
     * @param $testCaseID
     */
    public function test($productName, $menuItem, $option, $successMessage, $testCaseID)
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->manageStocks();
        sleep(1);
        $this->webposIndex->getManageStockList()->getInStockSwitchByProduct($productName)->click();
        self::assertTrue(
            $this->webposIndex->getManageStockList()->getUpdateButtonByProduct($productName)->isVisible(),
            "The Update Button by '$productName.'was not visible correctly."
        );
        $this->webposIndex->getManageStockList()->getUpdateButtonByProduct($productName)->click();
        sleep(1);
        if ($testCaseID == 'SET05') {
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->general();
            sleep(1);
            $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->click();
            $this->webposIndex->getGeneralSettingContentRight()->selectDisplayOption($option)->click();
            \PHPUnit_Framework_Assert::assertEquals(
                $successMessage,
                $this->webposIndex->getToaster()->getWarningMessage()->getText(),
                'On the Account Setting General Page - We could not save the display out of stock. Please check again.'
            );
        }

        sleep(2);
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->checkout();
        sleep(1);
        $this->webposIndex->getCheckoutProductList()->search($productName);
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        if ($testCaseID == 'SET05') {
            self::assertFalse(
                $this->webposIndex->getCheckoutProductList()->getProductNameSearch($productName)->isVisible(),
                "The Product Out Of Stock names '$productName.' must be invisible."
            );
        } elseif ($testCaseID == 'SET06') {
            self::assertTrue(
                $this->webposIndex->getCheckoutProductList()->getProductNameSearch($productName)->isVisible(),
                "The Product Out Of Stock names '$productName.' was not visible correctly."
            );
        }
        $this->productName = $productName;
        $this->menuItem = $menuItem;
        $this->option = $option;
        $this->testCaseID = $testCaseID;
    }

    public function tearDown()
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->manageStocks();
        sleep(1);
        $this->webposIndex->getManageStockList()->getInStockSwitchByProduct($this->productName)->click();
        self::assertTrue(
            $this->webposIndex->getManageStockList()->getUpdateButtonByProduct($this->productName)->isVisible(),
            "The Update Button by '$this->productName.'was not visible correctly."
        );
        $this->webposIndex->getManageStockList()->getUpdateButtonByProduct($this->productName)->click();
        if ($this->testCaseID == 'SET05') {
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->general();
            sleep(1);
            $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($this->menuItem)->click();
            $this->webposIndex->getGeneralSettingContentRight()->selectDisplayOption($this->option)->click();
        }
    }
}
