<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/02/2018
 * Time: 19:20
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Assert backend page title and it's availability.
 */
class AssertPageManageStaff extends AbstractConstraint
{
    const ERROR_TEXT = '404 Error';

    /**
     * Assert that backend page has correct title and 404 Error is absent on the page.
     *
     * @param StaffIndex $staffIndex
     * @param string $pageTitle
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, $pageTitle)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $pageTitle,
            $staffIndex->getTitleBlock()->getTitle(),
            'Invalid page title is displayed.'
        );
        \PHPUnit_Framework_Assert::assertNotContains(
            self::ERROR_TEXT,
            $staffIndex->getErrorBlock()->getContent(),
            "404 Error is displayed on '$pageTitle' page."
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Backend has correct title and 404 page content is absent.';
    }
}
