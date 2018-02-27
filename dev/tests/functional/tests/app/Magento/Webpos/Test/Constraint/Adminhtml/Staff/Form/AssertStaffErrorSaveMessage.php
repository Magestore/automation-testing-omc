<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Check that success message is displayed after widget saved
 */
class AssertStaffErrorSaveMessage extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffNews $staffNews
     * @return void
     */
    public function processAssert(StaffNews $staffNews, $idRequireds, $labelRequired)
    {
        $idRequiredsSplit = explode(', ', $idRequireds);
        foreach ($idRequiredsSplit as $fieldRequired){
            \PHPUnit_Framework_Assert::assertTrue(
                $staffNews->getStaffsForm()->isMessageRequiredDisplay($fieldRequired)->isVisible(),
                'Required '.$fieldRequired.' message is not displayed.'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $labelRequired,
                $staffNews->getStaffsForm()->getMessageRequired($fieldRequired),
                'Required '.$labelRequired.' message is not displayed.'
            );
        }

    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Required field is displayed.';
    }
}
