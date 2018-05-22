<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/17/18
 * Time: 4:26 PM
 */

namespace Magento\Webpos\Test\Constraint\Pos\Form;


use Magento\Mtf\Constraint\AbstractConstraint;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

class AssertSearchCloseSessionWithResult extends AbstractConstraint
{
    public function processAssert(PosNews $posNews, Staff $staff)
    {
        $posNews->getPosForm()->getTabByTitle('Closed Sessions')->click();
        $posNews->getPosForm()->waitForSessionGridLoad();
        $posNews->getPosForm()->searchClosedSessionValue(
            'sessions_grid_filter_staff_id', $staff->getDisplayName(),
            'select');
        \PHPUnit_Framework_Assert::assertFalse(
            $posNews->getPosForm()->getEmptyRowOfSessionGrid()->isVisible(),
            ' Don\'t have session open by ' . $staff->getDisplayName()
        );
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     */
    public function toString()
    {
        return 'Closed Session is displayed';
    }
}