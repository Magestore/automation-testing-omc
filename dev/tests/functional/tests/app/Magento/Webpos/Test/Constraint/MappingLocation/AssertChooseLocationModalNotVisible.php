<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/5/2018
 * Time: 4:00 PM
 */

namespace Magento\Webpos\Test\Constraint\MappingLocation;

use Magento\Webpos\Test\Page\Adminhtml\MappingLocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertChooseLocationModalNotVisible
 * @package Magento\Webpos\Test\Constraint\MappingLocation
 */
class AssertChooseLocationModalNotVisible extends AbstractConstraint
{
    /**
     * @param MappingLocationIndex $indexPage
     */
    public function processAssert(MappingLocationIndex $indexPage)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $indexPage->getLocationModal()->getDataGridHeader()->isVisible(),
            'Location Modal is visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Locations Modal is correctly.';
    }
}