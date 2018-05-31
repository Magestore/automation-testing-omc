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
 * Testcase ML04 - Sort by Description column
 *
 * Precondition
 * 1. Go to backend > Sales > Manage Locations
 *
 * Steps
 * 1. Click on title of Description column
 * 2. Click again
 *
 * Acceptance Criteria
 * 1. The records on grid will be sorted in ascending order (A to Z) by Description
 * 2. The records on grid will be sorted in descending order (Z to A) by Description
 *
 *
 * Class WebposManageLocationML04Test
 * @package Magento\Webpos\Test\TestCase\Location\CheckGUILocation
 */

class WebposManageLocationML04Test extends \Magento\Ui\Test\TestCase\GridSortingTest
{

}