<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/11/2017
 * Time: 6:14 PM
 */

namespace Magento\Storepickup\Test\Constraint\Tag;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\TagNew;

class AssertTagFormRequireFieldVisible extends AbstractConstraint
{

    public function processAssert(TagNew $tagNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $tagNew->getTagForm()->tagNameRequireErrorIsVisible(),
            'Tag name require error is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Require error is visible.';
    }
}