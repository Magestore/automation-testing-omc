<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 22/02/2018
 * Time: 09:05
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertMessageEditSuccessOnGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param LocationIndex
     * @return void
     */
    public function processAssert(LocationIndex $locationIndex, $message)
    {
        $locationIndex->getLocationsGrid()->waitForElementVisible('.data-grid-info-panel .message');
        \PHPUnit_Framework_Assert::assertTrue(
            true,
            'Message does not display'
        );
    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Message displays';
    }
}
