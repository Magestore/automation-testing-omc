<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 11:32 PM
 */

namespace Magento\Customercredit\Test\Constraint;

use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Customercredit\Test\Page\Adminhtml\CustomercreditIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertPageActionButtonIsAvailable
 * @package Magento\Customercredit\Test\Constraint
 */
class AssertPageActionButtonIsAvailable extends AbstractConstraint
{
    /**
     * @param CreditProductIndex $creditProductIndex
     * @param null $buttons
     */
    public function processAssert(CreditProductIndex $creditProductIndex, $buttons = null)
    {
        $creditProductIndex->getCreditProductGrid()->waitingForGridVisible();
        if ($buttons !== null) {
            $buttonArray = explode(",", $buttons);
            foreach ($buttonArray as $button) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $creditProductIndex->getCreditProductGridPageActions()->actionButtonIsVisible(trim($button)),
                    'Action button ' . $button . ' is not available.'
                );
            }
        }
    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'All buttons are available.';
    }
}