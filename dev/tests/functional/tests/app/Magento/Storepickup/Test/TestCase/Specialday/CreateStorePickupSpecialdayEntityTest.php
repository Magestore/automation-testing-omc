<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 9:51 AM
 */

namespace Magento\Storepickup\Test\TestCase\Specialday;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Fixture\StorepickupSpecialday;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayIndex;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayNew;

class CreateStorePickupSpecialdayEntityTest extends Injectable
{
    /**
     * @var SpecialdayIndex
     */
    protected $specialdayIndex;

    /**
     * @var SpecialdayNew
     */
    protected $specialdayNew;

    /**
     * @param SpecialdayIndex $specialdayIndex
     * @param SpecialdayNew $specialdayNew
     */
    public function __inject(SpecialdayIndex $specialdayIndex, SpecialdayNew $specialdayNew)
    {
        $this->specialdayIndex = $specialdayIndex;
        $this->specialdayNew = $specialdayNew;
    }

    public function test(StorepickupSpecialday $storepickupSpecialday)
    {
        $this->specialdayIndex->open();
        $this->specialdayIndex->getSpecialdayGridPageActions()->clickActionButton('add');
        $this->specialdayNew->getSpecialdayForm()->fill($storepickupSpecialday);
        $this->specialdayNew->getSpecialdayFormPageActions()->save();
    }
}