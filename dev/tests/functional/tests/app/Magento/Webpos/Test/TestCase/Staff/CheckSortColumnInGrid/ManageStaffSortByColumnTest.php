<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 02/05/2018
 * Time: 16:24
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckSortColumnInGrid;

use Magento\Ui\Test\TestCase\GridSortingTest;

/**
 * Class ManageStaffSortByColumnTest\
 *
 * Precondition: Exist at least 2 records on the grid
 * 1. Go to backend > Sales > Manage Staffs

 * Steps:
 * 1. Click on title of ID column
 * 2. Click again"
 *
 * Acceptance:
 * 1. The records on grid will be sorted in increasing ID
 * 2. The records on grid will be sorted in descending ID"
 *
 * @package Magento\Webpos\Test\TestCase\Staff\CheckSortColumnInGrid
 */
class ManageStaffSortByColumnTest extends GridSortingTest
{
}