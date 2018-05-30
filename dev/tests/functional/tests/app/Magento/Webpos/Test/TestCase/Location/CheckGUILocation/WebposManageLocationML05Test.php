<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 9:32 AM
 */

namespace Magento\Webpos\Test\TestCase\Location\CheckGUILocation;

/**
 * Check Sort column in Grid
 * Testcase ML05 - Sort by Address column
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on title of Description column
 * 2. Click again
 *
 * Acceptance Criteria
 * 1. The records on grid will be sorted in ascending order (A to Z) by Address
 * 2. The records on grid will be sorted in descending order (Z to A) by Address
 *
 * Class WebposManageLocationML05Test
 * @package Magento\Webpos\Test\TestCase\Location\CheckGUILocation
 */

class WebposManageLocationML05Test extends \Magento\Ui\Test\TestCase\GridSortingTest
{

}