<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 14:07
 */
namespace Magento\Webpos\Test\Constraint\Adminhtml\Location\Grid;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertCheckButtonOnGridWhenClick extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     *
     * @param LocationIndex
     * @return void
     */
    public function processAssert(LocationIndex $locationIndex, $nameButtons)
    {
        $nameButtons = explode(', ', $nameButtons);
        foreach ($nameButtons as $nameButton)
        {
            \PHPUnit_Framework_Assert::assertTrue(
                $locationIndex->getLocationsGrid()->getActionButtonEditing($nameButton)->isVisible(),
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
