<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 2:25 PM
 */

namespace Magento\Storepickup\Test\Constraint\Tag;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\TagNew;

/**
 * Class AssertTagFormAvailable
 * @package Magento\Storepickup\Test\Constraint\Tag
 */
class AssertTagFormAvailable extends AbstractConstraint
{
    /**
     * @param TagNew $tagNew
     */
    public function processAssert(TagNew $tagNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $tagNew->getTagForm()->isVisible(),
            'Tag form is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $tagNew->getTagForm()->generalTitleIsVisible(),
            'Tag form general title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $tagNew->getTagForm()->tagNameFieldIsVisible(),
            'Tag Name field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $tagNew->getTagForm()->descriptionFieldIsVisible(),
            'Description field is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $tagNew->getTagForm()->iconFieldIsVisible(),
            'Icon field is not visible.'
        );
        $tagNew->getTagForm()->openTab('stores');
        $tagNew->getTagForm()->waitOpenStoresTab();
        \PHPUnit_Framework_Assert::assertTrue(
            $tagNew->getTagForm()->storesGridIsVisible(),
            'Store grid is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Tag form is available';
    }
}