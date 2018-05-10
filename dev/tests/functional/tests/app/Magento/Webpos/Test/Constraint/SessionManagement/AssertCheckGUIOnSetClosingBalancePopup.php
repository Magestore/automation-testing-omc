<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 4:03 PM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertCheckGUIOnSetClosingBalancePopup
 * @package Magento\Webpos\Test\Constraint\SessionManagement
 */
class AssertCheckGUIOnSetClosingBalancePopup extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertEquals(
            "Fill in this form when you check money in the cash-drawer before closing Session",
            $webposIndex->getSessionSetClosingBalancePopup()->getNotice()->getText(),
            'Notice is not correct.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getTitleBox()->isVisible(),
            'Title is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getColumnCoin()->isVisible(),
            'Column Coin is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getColumnNumberOfCoins()->isVisible(),
            'Column Number of coins is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getColumnSubtotal()->isVisible(),
            'Column Subtotal is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getCancelButton()->isVisible(),
            'Cancel Button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getConfirmButton()->isVisible(),
            'Confirm Button is not visible.'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $webposIndex->getSessionSetClosingBalancePopup()->getAddNewRowButton()->isVisible(),
            'Add New Row Button is not visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Set Closing Balance Popup is correct.';
    }
}