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

class AssertPopupDelete extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param StaffNews
     * @return void
     */
    public function processAssert(StaffNews $staffNews, $info)
    {
        if($info['tag']=='open')
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $staffNews->getModalsWrapper()->getAsidePopup()->isVisible(),
                'Popup delete does not display'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $staffNews->getModalsWrapper()->getCancelButton()->isVisible(),
                'Cancel does not display'
            );
            \PHPUnit_Framework_Assert::assertTrue(
                $staffNews->getModalsWrapper()->getOkButton()->isVisible(),
                'Ok does not display'
            );
            \PHPUnit_Framework_Assert::assertEquals(
                $info['message'],
                $staffNews->getModalsWrapper()->getMessageDelete()->getText(),
                'Message does not fit expected'
            );
        } else if($info['tag']=='close')
        {
            \PHPUnit_Framework_Assert::assertFalse(
                $staffNews->getModalsWrapper()->getAsidePopup()->isVisible(),
                'Popup delete does not display'
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
        return 'Popup delete fits';
    }
}
