<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 8:38 AM
 */

namespace Magento\Rewardpoints\Test\Constraint;

use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Rewardpoints\Test\Page\Adminhtml\EarningRatesIndex;
use Magento\Storepickup\Test\Page\Adminhtml\StoreIndex;

class AssertDataGridAvailable extends AbstractConstraint
{

    public function processAssert(EarningRatesIndex $earningRatesIndex, $columns = null)
    {
        $earningRatesIndex->getEarningRatesGrid()->waitingForGridVisible();
        if ($columns !== null) {
            $columnArray = explode(",", $columns);
            foreach ($columnArray as $column) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $earningRatesIndex->getEarningRatesGrid()->columnIsVisible(trim($column)),
                    'Data column ' . $column . ' is not visible.'
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
        return 'All column is visible.';
    }
}