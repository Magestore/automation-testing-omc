<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 4/27/18
 * Time: 9:28 AM
 */

namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;

class AssertCheckButtonOnPageAction extends AbstractConstraint
{

    public function processAssert(LocationIndex $locationIndex, $buttonNames, $title){
        /*Check button display*/
        $buttons = explode(',', $buttonNames);
        foreach ($buttons as $button){
            $button = trim($button);
            \PHPUnit_Framework_Assert::assertTrue(
                $locationIndex->getPageActionsBlock()->getActionButtonByname($button)->isVisible(),
                'Button '.$button.' does not display'
            );
        }

        /*Check title display*/
        \PHPUnit_Framework_Assert::assertTrue(
            $locationIndex->getPageActionsBlock()->getPageTitleByName($title)->isVisible(),
            'Title is incorrect'
        );

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Buttons are display';
    }
}