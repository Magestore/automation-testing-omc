<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 7:54 AM
 */

namespace Magento\Customercredit\Test\Constraint\ReportTransactionDashboard;

use Magento\Customercredit\Test\Page\Adminhtml\ReportTransactionDashboard;
use Magento\Mtf\Constraint\AbstractConstraint;

class AssertReportTransactionDashboardAvailable extends AbstractConstraint
{

    public function processAssert(ReportTransactionDashboard $reportTransactionDashboard)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $reportTransactionDashboard->getDashboardBlock()->dashBoardIsVisible(),
            'Dashboard is not visible.'
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Report transaction dashboard is available';
    }
}