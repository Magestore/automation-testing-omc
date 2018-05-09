<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 08/05/2018
 * Time: 14:36
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckFilterFunction;

use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class ManageStaffMS10Test
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps:
 * "1. Click on [Filters] button
 * 2. Click on [Cancel] button"
 *
 * Acceptance:
 * "1. Open Filters form including:
 * - Fileds: ID, Username, Email, Display name, Location, Role, Status
 * - Buttons: Cancel, Apply Filters
 * 2. Close Filters form "
 *
 * @package Magento\Webpos\Test\TestCase\Staff\CheckFilterFunction
 */
class ManageStaffMS10Test extends \Magento\Mtf\TestCase\Injectable
{

    /**
     * Staff Index Page
     * @var StaffIndex
     */
    protected $staffIndex;

    public function __inject(
        StaffIndex $staffIndex
    )
    {
        $this->staffIndex = $staffIndex;
    }

    public function test()
    {
        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->waitLoader();
        $this->staffIndex->getStaffsGrid()->getFilterButton()->click();
        $this->staffIndex->getStaffsGrid()->waitForFilterCancelButton();
        $this->staffIndex->getStaffsGrid()->getFilterCancelButton()->click();
    }
}