<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/17/18
 * Time: 11:22 AM
 */

namespace Magento\Webpos\Test\Constraint\Pos\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

class AssertCheckPosInfomation extends AbstractConstraint
{
    public function processAssert(PosNews $posNews, Pos $pos)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $pos->getPosName(),
            $posNews->getPosForm()->getGeneralFieldById('page_pos_name')->getValue(),
            'Pos Information is displayed incorrectly '
        );

        \PHPUnit_Framework_Assert::assertEquals(
            $pos->getDataFieldConfig('location_id')['source']->getLocation()->getDisplayName(),
            $posNews->getPosForm()->getGeneralFieldById('page_location_id', 'select')->getValue(),
            'Pos Information is displayed incorrectly '
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Pos Information is displayed correctly';
    }
}