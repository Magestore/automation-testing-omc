<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 11:32 PM
 */

namespace Magento\Customercredit\Test\Constraint;

use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertDataGridToolbarIsAvailable extends AbstractConstraint
{

    public function processAssert(CreditProductIndex $creditProductIndex, $gridMassaction = true, $exportData = true)
    {
        $creditProductIndex->getCreditProductGrid()->waitingForGridVisible();
        \PHPUnit_Framework_Assert::assertTrue(
            $creditProductIndex->getCreditProductGrid()->searchButtonIsVisible(),
            'Search button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $creditProductIndex->getCreditProductGrid()->resetButtonIsVisible(),
            'Reset filter button is not visible.'
        );
        if ($gridMassaction) {
            \PHPUnit_Framework_Assert::assertTrue(
                $creditProductIndex->getCreditProductGrid()->gridMassactionFormIsVisible(),
                'Grid massaction form is not visible.'
            );
        }
        if ($exportData) {
            \PHPUnit_Framework_Assert::assertTrue(
                $creditProductIndex->getCreditProductGrid()->exportDataGridIsVisible(),
                'Export data grid is not visible.'
            );
        }
        \PHPUnit_Framework_Assert::assertTrue(
            $creditProductIndex->getCreditProductGrid()->dataGridPagerIsVisible(),
            'Grid pager is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $creditProductIndex->getCreditProductGrid()->dataGridFiltersIsVisible(),
            'Data grid filters is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Data grid header is available.';
    }
}