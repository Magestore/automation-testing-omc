<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:38 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class AssertCheckPosGridFilterShow extends AbstractConstraint
{

    public function processAssert(PosIndex $posIndex, $fields, $buttons){
        //Field
        $fields  = explode(',', $fields);
        foreach ($fields as $field){
            $field = trim($field);
            $this->assertField($posIndex, $field);
        }

        //Button
        $buttons  = explode(',', $buttons);
        foreach ($buttons as $button){
            $button = trim($button);
            $this->assertButton($posIndex, $button);
        }
    }

    private function assertField(PosIndex $posIndex, $field){
        \PHPUnit_Framework_Assert::assertTrue(
            $posIndex->getPosGrid()->getFilterFieldByName($field)->isVisible(),
            'Field '.$field.' not show in Filter'
        );
    }

    private function assertButton(PosIndex $posIndex, $button){
        \PHPUnit_Framework_Assert::assertTrue(
            $posIndex->getPosGrid()->getButtonFieldByName($button)->isVisible(),
            'Field '.$button.' not show in Filter'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Grid Filter show correct';
    }
}