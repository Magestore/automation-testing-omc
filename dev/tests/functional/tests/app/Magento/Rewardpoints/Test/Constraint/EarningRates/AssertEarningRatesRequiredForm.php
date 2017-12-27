<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 12/11/2017
 * Time: 1:29 PM
 */

namespace Magento\Rewardpoints\Test\Constraint\EarningRates;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesNew;


class AssertEarningRatesRequiredForm extends AbstractConstraint
{

    /**
     * @param EarningRatesNew $earningRatesNew
     */
    public function processAssert(EarningRatesNew $earningRatesNew)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $earningRatesNew->getEarningRatesForm()->fieldErrorIsVisible(),
            'EarningRates required field form is not visible.'
        );
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'EarningRates form is available.';
    }
}