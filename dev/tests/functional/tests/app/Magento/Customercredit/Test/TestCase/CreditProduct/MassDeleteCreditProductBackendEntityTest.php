<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/20/2017
 * Time: 1:07 PM
 */

namespace Magento\Customercredit\Test\TestCase\CreditProduct;

use Magento\Customercredit\Test\Fixture\CreditProduct;
use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;

class MassDeleteCreditProductBackendEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var CreditProductIndex
     */
    protected $creditProductIndex;

    public function __inject(
        FixtureFactory $fixtureFactory,
        CreditProductIndex $creditProductIndex
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->creditProductIndex = $creditProductIndex;
        $creditProductIndex->open();
        $creditProductIndex->getCreditProductGrid()->massaction([], 'Delete', true, 'Select All');
    }

    public function test($productQty, $productQtyToDelete)
    {
        /**
         * @var CreditProduct[] $products
         */
        $products = $this->createProducts($productQty);
        $deleteProducts = [];
        for ($i = 0; $i < $productQtyToDelete; $i++) {
            $deleteProducts[] = ['name' => $products[$i]->getName()];
        }
        $this->creditProductIndex->open();
        $this->creditProductIndex->getCreditProductGrid()->massaction($deleteProducts, 'Delete', true);

        return ['products' => $products];
    }

    public function createProducts($productQty)
    {
        $products = [];
        for ($i = 0; $i < $productQty; $i++) {
            $product = $this->fixtureFactory->createByCode('creditProduct', ['dataset' => 'default']);
            $product->persist();
            $products[] = $product;
        }

        return $products;
    }
}