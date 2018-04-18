<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 9:18 AM
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\Supplier;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Ui\Test\TestCase\GridSortingTest;

class SupplierGridSortingTest extends GridSortingTest
{
    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $supplier = $fixtureFactory->createByCode('supplier', ['dataset' => 'supplier_disable']);
        $supplier->persist();
    }
}