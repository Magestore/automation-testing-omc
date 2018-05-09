<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/2/18
 * Time: 8:57 AM
 */

namespace Magento\Webpos\Test\TestCase\Role\Sorting;


/**
 * Manage Role-Sorting MR03-MR04-MR05
 *
 * Sort by ID column
 *
 * Precondition
 * Exist at least 2 records on the grid
 *
 * Steps
 * 1.Go to backend->Sales->Manage Role
 * 2.1 Click on title of ID Column MR03
 * 2.2 Click on title of Display Name Column MR04
 * 2.3 Click on title of Description Column MR05
 * 3. Click again
 *
 * Class WebposManageRoleMR03Test
 * @package Magento\Webpos\Test\TestCase\Role\Sorting
 */
class WebposManageRoleSortingTest extends \Magento\Ui\Test\TestCase\GridSortingTest
{
}