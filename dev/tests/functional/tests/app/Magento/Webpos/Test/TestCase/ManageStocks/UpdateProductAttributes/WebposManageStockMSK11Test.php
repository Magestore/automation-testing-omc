<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/3/18
 * Time: 2:44 PM
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Manage Stock MSK11
 * Check prodcut list in mange stock
 *
 * Precondition
 * 1. Login Webpos as a staff
 * 2. Go to Manage Stocks page
 *
 * Step
 * 1.Edit a product:
 * Qty= < 0 (-2)
 * In stock: on
 * Manage stock: off
 * Backorders: on
 * 2.Update
 *
 * Class WebposManageStockMSK11Test
 * @package Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes
 */
class WebposManageStockMSK11Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test($productInfo)
    {
        $product = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\CreateNewProductByCurlStep', [
                'productData' => $productInfo['product']
            ]
        )->run();
        $staff = $this->objectManager->getInstance()->create('Magento\Webpos\Test\TestStep\LoginWebposStep')->run();
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->manageStocks();
        sleep(2);
        $productName = $product->getName();

        $this->webposIndex->getManageStockList()->searchProduct($productName);
        $this->webposIndex->getManageStockList()->waitForProductListShow();
        sleep(2);
        if (isset($productInfo['qty'])) {
            $this->webposIndex->getManageStockList()->getProductQtyInput($productName)->setValue($productInfo['qty']);
        }
        if (isset($productInfo['inStock'])) {
            $inStockCheckbox = $this->webposIndex->getManageStockList()->getProductInStockCheckbox($productName);
            $this->webposIndex->getManageStockList()->setCheckboxValue($inStockCheckbox, $productInfo['inStock']);
        }
        if (isset($productInfo['manageStock'])) {
            $manageStockCheckbox = $this->webposIndex->getManageStockList()->getProductManageStocksCheckbox($productName);
            $this->webposIndex->getManageStockList()->setCheckboxValue($manageStockCheckbox, $productInfo['manageStock']);
        }
        if (isset($productInfo['backOrders'])) {
            $backordersCheckbox = $this->webposIndex->getManageStockList()->getProductBackOrdersCheckbox($productName);
            $this->webposIndex->getManageStockList()->setCheckboxValue($backordersCheckbox, $productInfo['backOrders']);
        }

        // search and update attribute od product
        $this->webposIndex->getManageStockList()->getUpdateAllButton()->click();
        $this->webposIndex->getManageStockList()->waitForProductIconSuccess($productName);
        $this->webposIndex->getManageStockList()->resetSearchProduct();
        $this->webposIndex->getManageStockList()->waitForProductListShow();
        sleep(2);
        /*Check update product */
        $this->webposIndex->getManageStockList()->searchProduct($productName);
        $this->webposIndex->getManageStockList()->waitForProductListShow();
        sleep(2);

        return [
            'product' => $product
        ];
    }

}