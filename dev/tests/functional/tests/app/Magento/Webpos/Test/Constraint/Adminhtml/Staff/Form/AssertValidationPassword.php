<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 20/02/2018
 * Time: 20:31
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Staff\Form;
use Magento\Webpos\Test\Page\Adminhtml\StaffNews;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertValidationPassword extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    public function processAssert(StaffNews $staffNews, $message, $tag)
    {
        switch ($tag)
        {
            case '1' :
            {
                \PHPUnit_Framework_Assert::assertTrue(
                    $staffNews->getStaffsForm()->getTextBoxMessagePassConfim()->isVisible(),
                    'Show message is not visible'
                );
                \PHPUnit_Framework_Assert::assertEquals(
                    trim($message['1']),
                    $staffNews->getStaffsForm()->getTextBoxMessagePassConfim()->getText(),
                    'Show message is incorrect'
                );
                break;
            }

            case '2' :
            {
                \PHPUnit_Framework_Assert::assertTrue(
                    $staffNews->getStaffsForm()->getTextBoxMessagePassword()->isVisible(),
                    'Show message is not visible'
                );
                \PHPUnit_Framework_Assert::assertEquals(
                    trim($message['2']),
                    $staffNews->getStaffsForm()->getTextBoxMessagePassword()->getText(),
                    'Show message is incorrect'
                );
                break;
            }

            default :
            {
                \PHPUnit_Framework_Assert::assertTrue(
                    $staffNews->getStaffsForm()->getTextBoxMessagePassConfim()->isVisible(),
                    'Show message is not visible'
                );
                \PHPUnit_Framework_Assert::assertEquals(
                    trim($message['1']),
                    $staffNews->getStaffsForm()->getTextBoxMessagePassConfim()->getText(),
                    'Show message is incorrect'
                );
                \PHPUnit_Framework_Assert::assertTrue(
                    $staffNews->getStaffsForm()->getTextBoxMessagePassword()->isVisible(),
                    'Show message is not visible'
                );
                \PHPUnit_Framework_Assert::assertEquals(
                    trim($message['2']),
                    $staffNews->getStaffsForm()->getTextBoxMessagePassword()->getText(),
                    'Show message is incorrect'
                );
                break;
            }
        }

    }

    /**
     * Text of Required field message assert
     *
     * @return string
     */
    public function toString()
    {
        return 'Show message is correct';
    }
}
