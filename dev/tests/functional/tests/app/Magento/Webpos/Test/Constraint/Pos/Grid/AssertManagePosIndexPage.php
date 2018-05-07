<?php

namespace Magento\Webpos\Test\Constraint\Pos\Grid;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use PHPUnit_Framework_Assert;

/**
 * Created by PhpStorm.
 * User: bo
 * Date: 04/05/2018
 * Time: 15:35
 */

class AssertManagePosIndexPage extends \Magento\Mtf\Constraint\AbstractConstraint
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */

    public function processAssert(PosIndex $posIndex, $title, $buttonNames, $inputFieldNames, $massActions){
        \PHPUnit_Framework_Assert::assertEquals(
            $title,
            $posIndex->getTitleBlock()->getTitle(),
            'Invalid page title is displayed.'
        );

        $buttons = explode(',', $buttonNames);
        foreach ($buttons as $button){
            $button = trim($button);
            $this->assertButton($posIndex, $button);
        }

        $inputFields = explode(',', $inputFieldNames);
        foreach ($inputFields as $inputField){
            $inputField = trim($inputField);
            $this->assertGridDataField($posIndex, $inputField);
        }
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Buttons are showed correctly';
    }

    private function assertButton(PosIndex  $posIndex, $button){
        PHPUnit_Framework_Assert::assertTrue(
            $posIndex->getPosGrid()->getPageActionButtonValueByName($button)->isVisible(),
            'Button '.$button. ' could show incorrect'
        );
    }

    private function assertGridDataField(PosIndex $posIndex, $field){
        PHPUnit_Framework_Assert::assertTrue(
            $posIndex->getPosGrid()->getInputFieldGridByName($field)->isVisible(),
            'Field '.$field.' could show incorrect'
        );
    }
}