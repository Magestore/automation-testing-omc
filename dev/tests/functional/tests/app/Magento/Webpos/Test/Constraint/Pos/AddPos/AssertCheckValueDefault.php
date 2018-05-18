<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/15/18
 * Time: 3:24 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\AddPos;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;
use Magento\Webpos\Test\Page\Adminhtml\WebposRoleNew;

class AssertCheckValueDefault extends AbstractConstraint
{

    public function processAssert(PosNews $posNews, $tabs)
    {
        foreach ($tabs as $tab) {
            \PHPUnit_Framework_Assert::assertTrue($posNews->getPosForm()->getTabByTitle($tab['title'])->isVisible(),
                'Tab ' . $tab["title"] . ' doesn\'t display');
        }

        //General tab
        $this->assertGeneralTab($posNews, $tabs['general']);

        //Cash denomination
        $this->assertDenominationTab($posNews, $tabs['denomination']);

        //Closed Session
        $this->assertCloseSessionTabs($posNews, $tabs['close_sessions']);

        //Current Session Detail
        $this->assertCurrentSessionTab($posNews, $tabs['sessions_detail']);
    }

    private function assertGeneralTab(PosNews $posNews, $tab)
    {
        foreach ($tab['fields'] as $field) {
            \PHPUnit_Framework_Assert::assertTrue($posNews->getPosForm()->getGeneralFieldByTitle($field)->isVisible(),
                'Tab ' . $field . ' doesn\'t display');
        }

        \PHPUnit_Framework_Assert::assertEmpty(
            $posNews->getPosForm()->getGeneralFieldById('page_pos_name')->getText(),
            'Pos name input isn\'t blank'
        );

        \PHPUnit_Framework_Assert::assertEmpty(
            $posNews->getPosForm()->getGeneralFieldById('page_pos_name')->getText(),
            'Pos name input doesn\'t blank'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'Store Address',
            $posNews->getPosForm()->getGeneralFieldById('page_location_id', 'select')->getText(),
            'Default location didn\'t select'
        );

        \PHPUnit_Framework_Assert::assertEmpty(
            trim($posNews->getPosForm()->getGeneralFieldById('page_staff_id', 'select')->getText()),
            'Default Staff didn\'t blank'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'Enabled',
            $posNews->getPosForm()->getGeneralFieldById('page_status', 'select')->getText(),
            'Default Status didn\'t select'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'No',
            $posNews->getPosForm()->getGeneralFieldById('page_is_allow_to_lock', 'select')->getText(),
            'Default lock register didn\'t select'
        );

        \PHPUnit_Framework_Assert::assertEquals(
            'No',
            $posNews->getPosForm()->getGeneralFieldById('page_auto_join', 'checkbox')->getValue(),
            'Default available for other staff didn\'t check'
        );

    }

    private function assertDenominationTab(PosNews $posNews, $tab)
    {
        $this->openTab($posNews, $tab['title']);
        foreach ($tab['fields'] as $field) {
            \PHPUnit_Framework_Assert::assertTrue(
                $posNews->getPosForm()->getDenominationFieldByTitle($field)->isVisible(),
                'Field ' . $field . ' didn\'t display'
            );
        }
    }

    private function assertCloseSessionTabs(PosNews $posNews, $tab)
    {
        $this->openTab($posNews, $tab['title']);
        \PHPUnit_Framework_Assert::assertTrue(
            $posNews->getPosForm()->getSessionRowWithNoData()->isVisible(),
            'Some session is exist'
        );
    }

    private function assertCurrentSessionTab(PosNews $posNews, $tab)
    {
        $this->openTab($posNews, $tab['title']);
        \PHPUnit_Framework_Assert::assertTrue(
            $posNews->getPosForm()->getDefaultCurrentSession($tab['default_text'])->isVisible(),
            'Error with default current session'
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