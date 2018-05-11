<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 08/05/2018
 * Time: 13:57
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckFilterFunction;

use Magento\Ui\Test\TestCase\GridFilteringTest;

/**
 * Class ManageStaffMS13Test
 *
 * Precondition:
 * 1. Go to backend > Sales > Manage Staffs
 *
 * Steps:
 * "1. Click on [Filters] button
 * 2. Input data into all fields that match one or some records
 * 3. Click on [Filters] button"
 *
 * Acceptance:
 * "2.
 * - Close Filter form
 * - The records that matching condition will be shown on the grid"
 *
 * @package Magento\Webpos\Test\TestCase\Staff\CheckFilterFunction
 */
class ManageStaffMS13Test extends GridFilteringTest
{

}