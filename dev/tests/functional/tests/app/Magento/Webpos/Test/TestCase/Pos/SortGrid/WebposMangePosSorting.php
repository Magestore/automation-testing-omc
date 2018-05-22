<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 3:41 PM
 */
namespace Magento\Webpos\Test\TestCase\Pos\SortGrid;
/**
 * Webpos Manage Pos - Check Sort column in Grid
 * MP03-MP07 - Check Sort column in Grid
 *
 * Precondition
 * Exist at least 2 records on the grid
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2.
 * - MP03: Click on title of ID column
 * - MP04: Click on title of Name column
 * - MP05: Click on title of Location Name column
 * - MP06: Click on title of Display Name column
 * - MP07: Click on title of Status column
 * 3. Click again
 *
 * Acceptance
 * Records on grid will be sorted in respectively column
 *
 *
 * Class WebposMangePosSorting
 * @package Magento\Webpos\Test\TestCase\Pos\SortGrid
 */
class WebposMangePosSorting extends \Magento\Ui\Test\TestCase\GridSortingTest
{

}