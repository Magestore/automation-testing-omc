<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 5:55 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Class AssertFilterPosWithNoResult
 * @package Magento\Webpos\Test\Constraint\Pos\Grid
 */
class AssertFilterPosWithResult extends AbstractConstraint
{

    public function processAssert(PosIndex $posIndex, $filters = null)
    {
        $posIndex->getPosGrid()->waitLoader();
        $posIndex->getPosGrid()->getFilterButton()->click();
        $posIndex->getPosGrid()->resetFilter();

        foreach ($filters as $key => $value) {
            if ($key == 'pos_name') {
                $posIndex->getPosGrid()->getFilterByName($key)->setValue($value);
            } else {
                $posIndex->getPosGrid()->getFilterByName($key, 'select')->setValue($value);
            }
        }
        $posIndex->getPosGrid()->applyFilter();
        $posIndex->getPosGrid()->waitLoader();
        \PHPUnit_Framework_Assert::assertTrue($posIndex->getPosGrid()->getGridFirstRow()->isVisible(),
            'Pos Grid show no result');
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Pos Grid show with result';
    }

}