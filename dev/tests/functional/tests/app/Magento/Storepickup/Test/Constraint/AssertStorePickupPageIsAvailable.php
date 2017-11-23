<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 3:12 PM
 */

namespace Magento\Storepickup\Test\Constraint;

use Magento\Cms\Test\Page\CmsPage;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\StorepickupIndex;

class AssertStorePickupPageIsAvailable extends AbstractConstraint
{

    public function processAssert(StorepickupIndex $storepickupIndex, $pageTitle)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $pageTitle,
            $storepickupIndex->getStorepickupPageTitleBlock()->getStorepickupTitle(),
            'Invalid page title is displayed.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Store pickup page has correct title.';
    }
}