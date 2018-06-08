<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 02/05/2018
 * Time: 16:24
 */

namespace Magento\Webpos\Test\TestCase\Staff\CheckSortColumnInGrid;

use Magento\Ui\Test\TestCase\GridSortingTest;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Fixture\Staff;

/**
 * Class ManageStaffSortByColumnTest
 * @package Magento\Webpos\Test\TestCase\Staff\CheckSortColumnInGrid
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
 */
class ManageStaffSortByColumnTest extends GridSortingTest
{
    /**
     * (non-PHPdoc)
     * @see \Magento\Ui\Test\TestCase\GridSortingTest::test()
     */
    public function test(
        $pageClass,
        $gridRetriever,
        array $columnsForSorting,
        $fixtureName = null,
        $fixtureDataSet = null,
        $itemsCount = null,
        array $steps = [],
        $testCaseId = null
    )
    {
        if ($testCaseId && $testCaseId === "MS03") {
            if ($fixtureName && $fixtureDataSet) {
                //Create role and staff for role
                /**@var Location $location */
                $location = $this->fixtureFactory->createByCode('location', ['dataset' => 'default']);
                $location->persist();
                $locationId = $location->getLocationId();
                $posData['pos_name'] = 'Pos Test %isolation%';
                $posData['status'] = 'Enabled';
                $array = [];
                $array[] = $locationId;
                $posData['location_id'] = $array;
                /**@var Pos $pos */
                $pos = $this->fixtureFactory->createByCode('pos', ['data' => $posData]);
                $pos->persist();
                $posId = $pos->getPosId();
                $staff = $this->fixtureFactory->createByCode('staff', ['dataset' => 'staffMS03']);
                $staffData = $staff->getData();
                $array = [];
                $array[] = $locationId;
                $staffData['location_id'] = $array;
                $array = [];
                $array[] = $posId;
                $staffData['pos_ids'] = $array;
                /**@var Staff $staff */
                $staff = $this->fixtureFactory->createByCode('staff', ['data' => $staffData]);
                $staff->persist();
                $webposRole = $this->fixtureFactory->createByCode('webposRole', ['dataset' => 'role_ms77']);
                $roleData = $webposRole->getData();
                $array = [];
                $array[] = $staff->getStaffId();
                $roleData['staff_id'] = $array;
                $role = $this->fixtureFactory->createByCode('webposRole', ['data' => $roleData]);
                $role->persist();
            }
        }
        $this->assertTrue(false);
        $result = parent::test($pageClass, $gridRetriever, $columnsForSorting,
            null, null, null, $steps);

        return $result;
    }
}