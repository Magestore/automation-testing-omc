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
 * Manage Stock MSK10
 * Check prodcut list in mange stock
 *
 * Precondition
 * 1. LoginTest Webpos as a staff
 * 2. Go to Manage Stocks page
 *
 * Step
 * 1.Edit a product:
 * Qty=0
 * In stock: on
 * Manage stock: on
 * Backorders: off
 * 2. Update
 *
 * Acceptance Criteria
 * 2.
 * The information of that product in Database (table: cataloginventory_stock_item) will be updated:
 * - Qty=0
 * - is_in_stock: 0
 * - manage_stock: 1
 * - backorders : 0
 *
 * On webpos checkout page:
 * - Icon Out of stock displayed on product image
 *
 * Class WebposManageStockMSK10Test
 * @package Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes
 */
class WebposManageStockMSK10Test extends Injectable
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
        if (isset($productInfo['backorders'])) {
            $backordersCheckbox = $this->webposIndex->getManageStockList()->getProductBackOrdersCheckbox($productName);
            $this->webposIndex->getManageStockList()->setCheckboxValue($backordersCheckbox, $productInfo['backorders']);
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