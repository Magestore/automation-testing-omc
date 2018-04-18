<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 8:32 AM
 */

namespace Magento\Storepickup\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

/**
 * Class AssertPageActionButtonAvailable
 * @package Magento\Storepickup\Test\Constraint
 */
class AssertPageActionButtonAvailable extends AbstractConstraint
{

    /**
     * @param StoreIndex $storeIndex
     * @param null $buttons
     */
    public function processAssert(StoreIndex $storeIndex, $buttons = null)
    {
        $storeIndex->getStoreGrid()->waitingForGridVisible();
        if ($buttons !== null) {
            $buttonArray = explode(",", $buttons);
            foreach ($buttonArray as $button) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $storeIndex->getStoreGridPageActions()->actionButtonIsVisible(trim($button)),
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