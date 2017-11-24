<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 11:32 PM
 */

namespace Magento\Customercredit\Test\Constraint;

use Magento\Customercredit\Test\Page\Adminhtml\CreditProductIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertDataGridIsAvailable extends AbstractConstraint
{

    public function processAssert(CreditProductIndex $creditProductIndex, $columns = null)
    {
        $creditProductIndex->getDataGridBlock()->waitingForGridVisible();
        if ($columns !== null) {
            $columnArray = explode(",", $columns);
            foreach ($columnArray as $column) {
                \PHPUnit_Framework_Assert::assertTrue(
                    $creditProductIndex->getDataGridBlock()->columnIsVisible(trim($column)),
                    'Data column ' . $column . ' is not available.'
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
        return 'All columns are available.';
    }
}