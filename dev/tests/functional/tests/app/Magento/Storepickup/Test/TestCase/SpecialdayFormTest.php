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

/**
 * Class SpecialdayFormTest
 * @package Magento\Storepickup\Test\TestCase
 */
class SpecialdayFormTest extends Injectable
{
    /**
     * @var SpecialdayIndex
     */
    protected $specialdayIndex;

    /**
     * @param SpecialdayIndex $specialdayIndex
     */
    public function __inject(SpecialdayIndex $specialdayIndex)
    {
        $this->specialdayIndex = $specialdayIndex;
    }

    /**
     * @param $button
     */
    public function test($button)
    {
        $this->specialdayIndex->open();
        $this->specialdayIndex->getSpecialdayGridPageActions()->clickActionButton($button);
    }
}