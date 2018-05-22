<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/17/18
 * Time: 2:38 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\WebposIndex;

class AssertLoginWithDisabledPos extends AbstractConstraint
{

    public function processAssert(WebposIndex $webposIndex, Pos $pos)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getLoginForm()->getOptionFieldByValue('pos', $pos->getPosName())->isVisible(),
            'Pos ' . $pos->getPosName() . ' didn\'t disable'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Pos is disabled success';
    }
}