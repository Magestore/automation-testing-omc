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
use PHP_CodeSniffer\Tokenizers\PHP;

/**
 * Class AssertFilterPosWithNoResult
 * @package Magento\Webpos\Test\Constraint\Pos\Grid
 */
class AssertFilterPosWithNoResult extends AbstractConstraint
{

    public function processAssert(PosIndex $posIndex, $filter=null)
    {
        $posIndex->getPosGrid()->waitLoader();
        $posIndex->getPosGrid()->resetFilter();
        if (empty($filter)){
            $filter = [];
        }
        \PHPUnit_Framework_Assert::assertFalse(
            $posIndex->getPosGrid()->isRowVisible($filter),
            'Pos Grid shows with result'
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Pos Grid show with no result';
    }
}