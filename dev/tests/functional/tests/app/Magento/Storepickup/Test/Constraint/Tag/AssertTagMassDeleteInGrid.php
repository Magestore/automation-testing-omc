<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 2:56 PM
 */

namespace Magento\Storepickup\Test\Constraint\Tag;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupTag;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;

class AssertTagMassDeleteInGrid extends AbstractConstraint
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
        $tags = array_slice($tags, $tagsQtyToDelete);
       foreach ($tags as $tag) {
            \PHPUnit_Framework_Assert::assertTrue(
                $tagIndex->getTagGrid()->isRowVisible(['name' => $tag->getTagName()]),
                'Tag with name ' . $tag->getTagName() . 'is absent in Tag grid.'
            );
        }
    }

    /**
     * Success message if Tag in grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Tags are present in Tags grid.';
    }
}