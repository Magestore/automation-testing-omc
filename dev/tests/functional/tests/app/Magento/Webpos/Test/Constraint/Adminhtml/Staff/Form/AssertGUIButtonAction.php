<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 21/02/2018
 * Time: 20:03
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertGUIButtonAction extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffNews $staffNews
     * @return void
     */
    public function processAssert(StaffNews $staffNews, $idButtons)
    {
        $idButtons = explode(', ',$idButtons);
        foreach ($idButtons as $idButton)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffNews->getFormPageActionsStaff()->getButtonById($idButton)->isVisible(),
                'Button '.$idButton.' is not display'
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
        return 'Buttons is enough';
    }
}
