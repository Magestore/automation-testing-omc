<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Grid;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;
use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;

class AssertCheckButtonOnGridWhenClick extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffIndex $staffIndex
     * @return void
     */
    public function processAssert(StaffIndex $staffIndex, $nameButtons)
    {
        $nameButtons = explode(', ', $nameButtons);
        foreach ($nameButtons as $nameButton)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffIndex->getStaffsGrid()->getActionButtonEditing($nameButton)->isVisible(),
                'Button'.$nameButton.'does not display'
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
        return 'Buttons are display';
    }
}
