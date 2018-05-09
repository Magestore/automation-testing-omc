<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 08/05/2018
 * Time: 15:55
 */

namespace Magento\Webpos\Test\TestCase\Staff\MassAction;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\StaffIndex;

/**
 * Class ManageStaffMS14Test
 * @package Magento\Webpos\Test\TestCase\Staff\MassAction
 */
class ManageStaffMS14Test extends Injectable
{
    /**
     * Staff Index Page
     * @var StaffIndex
     */
    protected $staffIndex;

    /**
     * Fixture factory.
     *
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    public function __inject(
        StaffIndex $staffIndex,
        FixtureFactory $fixtureFactory
    )
    {
        $this->staffIndex = $staffIndex;
        $this->fixtureFactory = $fixtureFactory;
    }

    public function test()
    {
        $staff = $this->fixtureFactory->createByCode('staff', ['dataset' => 'default']);
        $staff->persist();
        $this->staffIndex->open();
        $this->staffIndex->getStaffsGrid()->waitLoader();
        $this->staffIndex->getStaffsGrid()->getFilterButton()->click();
        $this->staffIndex->getStaffsGrid()->resetFilter();
        $this->staffIndex->getStaffsGrid()->searchAndSelect([
            'username' => $staff->getUsername()
        ]);
        $this->staffIndex->getStaffsGrid()->selectAction('Delete');
        $this->staffIndex->getModal()->waitForLoader();
        \PHPUnit_Framework_Assert::assertEquals(
            'Are you sure you want to delete selected items?',
            $this->staffIndex->getModal()->getMessageDelete()->getText(),
            'Modal message delete error'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $this->staffIndex->getModal()->getCancelButton()->isVisible(),
            'Button Cancel button not visible'
        );
        \PHPUnit_Framework_Assert::assertTrue(
            $this->staffIndex->getModal()->getOkButton()->isVisible(),
            'Button Ok button not visible'
        );
        $this->staffIndex->getModal()->getCancelButton()->click();
        sleep(1);
        \PHPUnit_Framework_Assert::assertFalse(
            $this->staffIndex->getModal()->getModalPopup()->isVisible(),
            'Modal is not closed'
        );
    }
}