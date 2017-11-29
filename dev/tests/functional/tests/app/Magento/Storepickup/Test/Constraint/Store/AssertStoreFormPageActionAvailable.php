<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 9:53 AM
 */

namespace Magento\Storepickup\Test\Constraint\Store;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Storepickup\Test\Page\Adminhtml\StoreNew;

/**
 * Class AssertStoreFormPageActionAvailable
 * @package Magento\Storepickup\Test\Constraint\Store
 */
class AssertStoreFormPageActionAvailable extends AbstractConstraint
{

    /**
     * @param StoreNew $storeNew
     * @param $buttons
     */
    public function processAssert(StoreNew $storeNew, $buttons)
    {
        if ($buttons !== null) {
            $buttonArray = explode(",", $buttons);
            foreach ($buttonArray as $button) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $storeNew->getStoreFormPageActions()->actionButtonIsVisible($button),
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
        return 'Store form page action is visible.';
    }
}