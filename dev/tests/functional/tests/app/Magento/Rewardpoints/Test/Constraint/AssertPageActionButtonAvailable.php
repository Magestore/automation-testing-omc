<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 8:32 AM
 */

namespace Magento\Rewardpoints\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;

/**
 * Class AssertPageActionButtonAvailable
 * @package Magento\Rewardpoints\Test\Constraint
 */
class AssertPageActionButtonAvailable extends AbstractConstraint
{

    /**
     * @param EarningRatesIndex $earningRatesIndex
     * @param null $buttons
     */
    public function processAssert(EarningRatesIndex $earningRatesIndex, $buttons = null)
    {
        $earningRatesIndex->getEarningRatesGrid()->waitingForGridVisible();
        if ($buttons !== null) {
            $buttonArray = explode(",", $buttons);
            foreach ($buttonArray as $button) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $earningRatesIndex->getEarningRatesGridPageActions()->actionButtonIsVisible(trim($button)),
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
        return 'All page action button is visible.';
    }
}