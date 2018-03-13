<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 4:46 PM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertSetClosingBalancePopupNotVisible
 * @package Magento\Webpos\Test\Constraint\SessionManagement
 */
class AssertSetClosingBalancePopupNotVisible extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getSessionSetClosingBalancePopup()->isVisible(),
            'Set Closing Balance Popup is visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Set Closing Balance Popup is not visible.';
    }
}