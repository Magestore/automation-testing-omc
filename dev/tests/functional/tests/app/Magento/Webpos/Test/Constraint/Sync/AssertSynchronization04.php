<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 3/1/2018
 * Time: 1:26 PM
 */

namespace Magento\Webpos\Test\Constraint\Sync;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Customer\Test\Fixture\Customer;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertSynchronization04 extends AbstractConstraint
{
    public function processAssert(
        WebposIndex $webposIndex,
        CatalogProductSimple $product,
        Customer $customer
    )
    {
        $itemList = [
            'Swatch Option',
            'Configuration',
            'Category',
            'Product',
            'Stock Item',
            'Shift',
            'Group',
            'Customer Complaints',
            'Customer',
            'Currency',
            'Country',
            'Order',
            'Payment',
            'Shipping',
            'Tax Rate',
            'Tax Classes',
            'Tax rule'
        ];
        foreach ($itemList as $item) {
            \PHPUnit_Framework_Assert::assertTrue(
                $webposIndex->getSyncTabData()->getItemRowProgress($item)->isVisible(),
                'Synchronization - '.$item.' - progress bar is not shown'
            );
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return "Synchronization - Update All: Success";
    }
}