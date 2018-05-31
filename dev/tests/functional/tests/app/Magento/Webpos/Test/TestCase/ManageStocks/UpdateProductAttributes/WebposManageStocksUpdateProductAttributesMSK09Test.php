<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 09/03/2018
 * Time: 08:00
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes;


use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Manage Stock MSK09
 * Update the product attributes
 *
 * Precondition
 * 1. Login Webpos as a staff
 * 2. Go to Manage Stocks page
 *
 * Step
 * 1. Edit Qty and Switch cases of some  products
 * 2.  Click on Update all
 *
 * Acceptance Criteria
 * 1. Hide update actions on each row just edit
 * 2. Those  products will be updated in backend
 *
 * Class WebposManageStocksUpdateProductAttributesMSK09Test
 * @package Magento\Webpos\Test\TestCase\ManageStocks\UpdateProductAttributes
 */
class WebposManageStocksUpdateProductAttributesMSK09Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * Inject
     *
     * @param WebposIndex $webposIndex
     * @param FixtureFactory $fixtureFactory
     */
    public function __inject(
        WebposIndex $webposIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->webposIndex = $webposIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * Test Steps
     *
     * @param $productList
     * @return array
     */
    public function test(
        $productList
    )
    {
        // Create product
        foreach ($productList as $key => $item) {
            $productList[$key]['product'] = $this->objectManager->getInstance()->create(
                'Magento\Webpos\Test\TestStep\CreateNewProductByCurlStep',
                [
                    'productData' => $productList[$key]['product']
                ]
            )->run();
        }

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->manageStocks();
        sleep(2);

        $this->webposIndex->getManageStockList()->searchProduct('Simple Product MSK09');
        $this->webposIndex->getManageStockList()->getStoreAddress()->click();
        sleep(5);

        foreach ($productList as $item) {

            $productName = $item['product']->getName();

            // Edit product info

            if (isset($item['qty'])) {
                $this->webposIndex->getManageStockList()->getProductQtyInput($productName)->setValue($item['qty']);
            }
            if (isset($item['inStock'])) {
                $inStockCheckbox = $this->webposIndex->getManageStockList()->getProductInStockCheckbox($productName);
                $this->webposIndex->getManageStockList()->setCheckboxValue($inStockCheckbox, $item['inStock']);
            }
            if (isset($item['manageStock'])) {
                $manageStockCheckbox = $this->webposIndex->getManageStockList()->getProductManageStocksCheckbox($productName);
                $this->webposIndex->getManageStockList()->setCheckboxValue($manageStockCheckbox, $item['manageStock']);
            }
            if (isset($item['backorders'])) {
                $backordersCheckbox = $this->webposIndex->getManageStockList()->getProductBackOrdersCheckbox($productName);
                $this->webposIndex->getManageStockList()->setCheckboxValue($backordersCheckbox, $item['backorders']);
            }
        }

        // action
        $this->webposIndex->getManageStockList()->getUpdateAllButton()->click();
        foreach ($productList as $item) {
            $productName = $item['product']->getName();
            $this->webposIndex->getManageStockList()->waitForProductIconSuccess($productName);
        }

        return [
            'productList' => $productList
        ];
    }
}