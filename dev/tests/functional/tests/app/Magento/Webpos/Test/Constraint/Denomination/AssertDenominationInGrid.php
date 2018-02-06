<?php
namespace Magento\Webpos\Test\Constraint\Denomination;
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/6/2017
 * Time: 4:32 PM
 */
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Page\Adminhtml\DenominationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertDenominationInGrid
 */
class AssertDenominationInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'high';
    /* end tags */

    /**
     * @param Staff Denomination Index
     */
    protected $denominationIndex;
    /**
     * Assert denomination availability in denomination grid
     *
     * @param Denomination $denomination
     * @param DenominationIndex $denominationIndex
     * @return void
     */
    public function processAssert(Denomination $denomination, DenominationIndex $denominationIndex)
    {
        $filter = ['denomination_name' => $denomination->getDenominationName()];
        $denominationIndex->open();
        \PHPUnit_Framework_Assert::assertTrue(
            $denominationIndex->getDenominationsGrid()->isRowVisible($filter),
            'Webpos Cash Denomination with Denomination Name \'' . $denomination->getDenominationName() . '\' is absent in Webpos Denomination Denomination grid.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Webpos Cash Denomination is present in Webpos Staff timezone_denomination_get() grid.';
    }
}