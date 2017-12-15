<?php
/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 12/8/2017
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\Constraint\Denomination;

use Magento\Webpos\Test\Page\Adminhtml\DenominationNews;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertDenominationVisibleForm
 * @package Magento\Webpos\Test\Constraint\Denomination
 */
class AssertDenominationNewVisibleForm extends AbstractConstraint
{
    /**
     * @param DenominationNews $denominationNews
     */
    public function processAssert(DenominationNews $denominationNews, $titleAddDenomination)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            $titleAddDenomination,
            $denominationNews->getPageWrapper()->getTitleAddDenomination()->getText(),
            'Title Add Denomination Section Is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $denominationNews->getContainer()->getFieldDenominationName()->isVisible(),
            'On The Backend Page, the Field Name Add Denomination Of the Extension was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $denominationNews->getContainer()->getFieldDenominationValue()->isVisible(),
            'On The Backend Page, the Field Value Add Denomination Of the Extension was not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $denominationNews->getContainer()->getFieldDenominationSortOrder()->isVisible(),
            'On The Backend Page, the Field Sort Order Add Denomination Of the Extension was not visible.'
        );
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'On The Backend Page, all the elements Button in the Grid Header Page Of the Extension Webpos was visible successfully.';
    }
}