<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/20/2017
 * Time: 1:51 PM
 */

namespace Magento\Customercredit\Test\TestCase\CreditProduct;

use Magento\Customercredit\Test\Fixture\CreditProduct;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

/**
 * Test Flow:
 * Preconditions:
 * 1. Create 2 credit products enable or disable
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  Store Credit > Manage Credit Products
 * 3. Select 2 products from preconditions
 * 4. Select in dropdown "Change Status" and choose status "Enable" or "Disable"
 * 5. Click Submit button
 * 6. Perform all assertions according to dataset
 *
 */
class MassChangeStatusCreditProductBackendEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var CreditProductIndex
     */
    protected  $creditProductIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param CreditProductIndex $storeIndex
     */
    public function __inject(
        FixtureFactory $fixtureFactory,
        CreditProductIndex $creditProductIndex
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->creditProductIndex = $creditProductIndex;
        $creditProductIndex->open();
        $creditProductIndex->getCreditProductGrid()->resetFilter();
        $creditProductIndex->getCreditProductGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test($productsQty, $productDataSet, $status)
    {
        $products = $this->createProducts($productsQty, $productDataSet);
        $massActionProducts = [];
        foreach ($products as $product) {
            $massActionProducts[] = ['name' => $product->getName()];
        }
        $this->creditProductIndex->open();
        $this->creditProductIndex->getCreditProductGrid()->massaction($massActionProducts, 'Change status', false, '', $status);

        return ['products' => $products];
    }

    public function createProducts($productQty, $productDataSet)
    {
        /**
         * @var CreditProduct[] $products
         */
        $products = [];
        for ($i = 0; $i < $productQty; $i++) {
            $product = $this->fixtureFactory->createByCode('creditProduct', ['dataset' => $productDataSet]);
            $product->persist();
            $products[] = $product;
        }

        return $products;
    }
}