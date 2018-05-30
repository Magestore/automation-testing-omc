<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;


/**
 * Check Sort column in Grid
 * Testcase ML03 - Sort by ID column
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on title of ID column
 * 2. Click again
 *
 * Acceptance Criteria
 * 1. The records on grid will be sorted in increasing ID
 * 2. The records on grid will be sorted in descending ID
 *
 * Class WebposManageLocationML03Test
 * @package Magento\Webpos\Test\TestCase\Location\CheckGUILocation
 */
class WebposManageLocationML03Test extends \Magento\Ui\Test\TestCase\GridSortingTest
{
}