<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/15/18
 * Time: 3:24 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\AddPos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Denomination;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

class AssertCheckValueField extends AbstractConstraint
{

    public function processAssert(PosNews $posNews, Location $location, Staff $staff, Denomination $denomination)
    {
        $this->assertOptionValue($posNews, $location->getDisplayName());
        $this->assertOptionValue($posNews, $staff->getDisplayName());

        //Status
        $this->assertOptionValue($posNews, 'Enabled');
        $this->assertOptionValue($posNews, 'Disabled');

        //Lock Register
        $this->assertOptionValue($posNews, 'Yes');
        $this->assertOptionValue($posNews, 'No');

        //Denomination
        $this->assertDenominationGridData($posNews, $denomination->getDenominationName());
    }

    private function assertOptionValue(PosNews $posNews, $title)
    {
        \PHPUnit_Framework_Assert::assertTrue(
            $posNews->getPosForm()->getOptionByTitle($title)->isVisible(),
            $title . ' is not displayed'
        );
    }

    private function assertDenominationGridData(PosNews $posNews, $name)
    {
        $this->openTab($posNews, 'Cash Denominations');
        $posNews->getPosForm()->searchDenominationByName($name);
        sleep(1);
        \PHPUnit_Framework_Assert::assertTrue(
            $posNews->getPosForm()->getDenominationFirstData()->isVisible(),
            'No exist any denomination'
        );
    }

    private function openTab(PosNews $posNews, $title)
    {
        $posNews->getPosForm()->getTabByTitle($title)->click();
        sleep(1);
    }


    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Default Value is displayed correct';
    }

}