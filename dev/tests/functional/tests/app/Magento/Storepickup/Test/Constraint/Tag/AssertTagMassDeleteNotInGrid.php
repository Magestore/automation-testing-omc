<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 2:49 PM
 */

namespace Magento\Storepickup\Test\Constraint\Tag;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupTag;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;

class AssertTagMassDeleteNotInGrid extends AbstractConstraint
{
    /**
     *
     * @param TagIndex $tagIndex
     * @param int $tagsQtyToDelete
     * @param StorepickupTag[] $tags
     * @return void
     */
    public function processAssert(
        TagIndex $tagIndex,
        $tagsQtyToDelete,
        $tags
    ) {
        for ($i = 0; $i < $tagsQtyToDelete; $i++) {
            \PHPUnit_Framework_Assert::assertFalse(
                $tagIndex->getTagGrid()->isRowVisible(['name' => $tags[$i]->getTagName()]),
                'Tag with name ' . $tags[$i]->getTagName() . 'is present in Tag grid.'
            );
        }
    }

    /**
     * Success message if Tag not in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Deleted Tags are absent in Tags grid.';
    }
}