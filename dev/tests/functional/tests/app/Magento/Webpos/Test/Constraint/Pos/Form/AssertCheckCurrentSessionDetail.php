<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/18/18
 * Time: 7:53 AM
 */

namespace Magento\Webpos\Test\Constraint\Pos\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

class AssertCheckCurrentSessionDetail extends AbstractConstraint
{
    public function processAssert(PosNews $posNews, Staff $staff, $session_info)
    {
        $this->assertClosedSession($posNews, $staff);
        $this->assertCurrentSessionDetail($posNews, $session_info);
    }

    private function assertClosedSession(PosNews $posNews, Staff $staff)
    {
        $posNews->getPosForm()->getTabByTitle('Closed Sessions')->click();
        $posNews->getPosForm()->waitForSessionGridLoad();
        $posNews->getPosForm()->searchClosedSessionValue('sessions_grid_filter_staff_id', $staff->getDisplayName(), 'select');
        \PHPUnit_Framework_Assert::assertFalse(
            $posNews->getPosForm()->getEmptyRowOfSessionGrid()->isVisible(),
            'Doesn\'t exist session with staff ' . $staff->getDisplayName()
        );
        if (!$posNews->getPosForm()->getEmptyRowOfSessionGrid()->isVisible()) {
            \PHPUnit_Framework_Assert::assertEmpty(
                trim($posNews->getPosForm()->getClosedAtSessionFirstRowData()->getText()),
                'Closed At isn\'t empty'
            );
        }
    }

    private function assertCurrentSessionDetail(PosNews $posNews, $session_info)
    {
        $posNews->getPosForm()->getTabByTitle('Current Sessions Detail')->click();
        $posNews->getPosForm()->waitForCurrentSessionLoad();

        \PHPUnit_Framework_Assert::assertTrue(
            $posNews->getPosForm()->getCurrentSessionTitle('Current Session')->isVisible(),
            'Title didn\'t display'
        );
        $labels = array_map('trim', explode(',', $session_info['labels']));
        foreach ($labels as $label) {
            \PHPUnit_Framework_Assert::assertTrue(
                $posNews->getPosForm()->getCurrentSessionLabelByTitle($label)->isVisible(),
                $label . 'didn\'t display'
            );
        }
        $buttons = array_map('trim', explode(',', $session_info['buttons']));
        foreach ($buttons as $button) {
            \PHPUnit_Framework_Assert::assertTrue(
                $posNews->getPosForm()->getCurrentSessionButtonByTitle($button)->isVisible(),
                $button . 'didn\'t display'
            );
        }

    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Current Session is displayed correct';
    }
}