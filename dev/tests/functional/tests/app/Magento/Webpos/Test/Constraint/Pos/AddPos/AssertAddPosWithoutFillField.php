<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/15/18
 * Time: 2:55 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\AddPos;

use Magento\Webpos\Test\Page\Adminhtml\PosNews;

class AssertAddPosWithoutFillField extends \Magento\Mtf\Constraint\AbstractConstraint
{

    public function processAssert(PosNews $posNews, $requiredText)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $posNews->getPosForm()->getPosNameErrorLabel()->isVisible(),
            'Pos_name field require is not displayed'
        );
        if($posNews->getPosForm()->getPosNameErrorLabel()->isVisible()){
            \PHPUnit_Framework_Assert::assertEquals(
                $requiredText,
                $posNews->getPosForm()->getPosNameErrorLabel()->getText(),
                'Required Text doesn\'t show correct'
            );

        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'New Pos Page has error';
    }
}