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

class AssertDataGridHeaderIsAvailable extends AbstractConstraint
{

    public function processAssert(CreditProductIndex $creditProductIndex)
    {
        $creditProductIndex->getDataGridBlock()->waitingForGridVisible();

    }
    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Data grid header is available.';
    }
}