<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/14/2018
 * Time: 8:10 AM
 */

namespace Magento\Webpos\Test\Constraint\SessionManagement;

use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertConfirmModalPopupNotVisible
 * @package Magento\Webpos\Test\Constraint\SessionManagement
 */
class AssertConfirmModalPopupNotVisible extends AbstractConstraint
{
    /**
     * @param WebposIndex $webposIndex
     */
    public function processAssert(WebposIndex $webposIndex)
    {
        \PHPUnit_Framework_Assert::assertFalse(
            $webposIndex->getSessionConfirmModalPopup()->isVisible(),
            'Confirm Modal Popup is visible.'
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Confirm Modal Popup is correct.';
    }
}