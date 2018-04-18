<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 6:22 PM
 */

namespace Magento\Storepickup\Test\Constraint\Tag;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Fixture\StorepickupTag;
use Magento\Storepickup\Test\Page\Adminhtml\TagIndex;

class AssertTagInGrid extends AbstractConstraint
{
    /**
     * Filters array mapping.
     *
     * @var array
     */
    private $filter;

    public function processAssert(
        StorepickupTag $storepickupTag,
        TagIndex $tagIndex
    ) {
        $tagIndex->open();
        $data = $storepickupTag->getData();
        $this->filter = ['name' => $data['tag_name']];
        $tagIndex->getTagGrid()->search($this->filter);

        \PHPUnit_Framework_Assert::assertTrue(
            $tagIndex->getTagGrid()->isRowVisible($this->filter, false, false),
            'Tag is absent in Tag grid'
        );

//        \PHPUnit_Framework_Assert::assertEquals(
//            count($tagIndex->getTagGrid()->getAllIds()),
//            1,
//            'There is more than one tag founded'
//        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Tag is present in grid.';
    }
}