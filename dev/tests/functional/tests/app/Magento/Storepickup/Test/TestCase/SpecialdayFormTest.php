<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/23/2017
 * Time: 9:49 AM
 */

namespace Magento\Storepickup\Test\TestCase;

use Magento\Mtf\TestCase\Injectable;
use Magento\Storepickup\Test\Page\Adminhtml\SpecialdayIndex;

class SpecialdayFormTest extends Injectable
{
    /**
     * @var SpecialdayIndex
     */
    protected $specialdayIndex;

    public function __inject(SpecialdayIndex $specialdayIndex)
    {
        $this->specialdayIndex = $specialdayIndex;
    }

    public function test($button)
    {
        $this->specialdayIndex->open();
        $this->specialdayIndex->getSpecialdayGridPageActions()->clickActionButton($button);
    }
}