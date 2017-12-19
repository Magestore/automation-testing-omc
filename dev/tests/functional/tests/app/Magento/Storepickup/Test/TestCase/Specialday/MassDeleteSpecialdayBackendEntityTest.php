<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/19/2017
 * Time: 3:55 PM
 */

namespace Magento\Storepickup\Test\TestCase\Specialday;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayIndex;

class MassDeleteSpecialdayBackendEntityTest extends Injectable
{
    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * @var SpecialdayIndex
     */
    protected $specialdayIndex;

    /**
     * @param FixtureFactory $fixtureFactory
     * @param SpecialdayIndex $specialdayIndex
     */
    public function __inject(
        FixtureFactory $fixtureFactory,
        SpecialdayIndex $specialdayIndex
    ){
        $this->fixtureFactory = $fixtureFactory;
        $this->specialdayIndex = $specialdayIndex;
    }

    public function test($specialdaysQty, $specialdaysQtyToDelete)
    {
        $specialdays = $this->createSpecialdays($specialdaysQty);
        $deleteSpecialdays = [];
        for ($i = 0; $i < $specialdaysQtyToDelete; $i++) {
            $deleteSpecialdays[] = ['name' => $specialdays[$i]->getSpecialdayName()];
        }
        $this->specialdayIndex->open();
        $this->specialdayIndex->getSpecialdayGrid()->massaction($deleteSpecialdays, 'Delete', true);

        return ['specialdays' => $specialdays];
    }

    public function createSpecialdays($specialdaysQty)
    {
        $specialdays = [];
        for ($i = 0; $i < $specialdaysQty; $i++) {
            $specialday = $this->fixtureFactory->createByCode('storepickupSpecialday', ['dataset' => 'default1']);
            $specialday->persist();
            $specialdays[] = $specialday;
        }
        return $specialdays;
    }
}