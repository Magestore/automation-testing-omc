<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 23/02/2018
 * Time: 23:20
 */

namespace Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\Fixture\DataSource;

class StaffId extends DataSource
{
    /**
     * @var Staff[]
     */
    protected $staffs;

//    /**
//     * @constructor
//     * @param FixtureFactory $fixtureFactory
//     * @param array $params
//     * @param array $data
//     */
//    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
//    {
//        $this->params = $params;
//        if (isset($data['dataset'])) {
//            /** @var Staff $staff */
//            $staff = $fixtureFactory->createByCode('staff', ['dataset' => $data['dataset']]);
//            $staff->persist();
//            $this->staff = $staff->getData();
//            $this->data = $staff->getStaffId();
//        } else {
//            $this->data = null;
//        }
//    }

    public function __construct(FixtureFactory $fixtureFactory, array $params, array $data = [])
    {
        $this->params = $params;
        if (isset($data['dataset'])) {
            $staffDataSets = explode(',', $data['dataset']);
            foreach ($staffDataSets as $staffDataSet) {
                $staff = $fixtureFactory->createByCode('staff', ['dataset' => $staffDataSet]);
                $staff->persist();
                $this->data[] = $staff->getStaffId();
                $this->staffs[] = $staff;
            }
        } else {
            $this->data = null;
        }
    }

    /**
     * Return staff.
     *
     * @return Staff[]
     */
    public function getStaffs()
    {
        return $this->staffs;
    }
}
