<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\MassAction;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Constraint\Pos\MassAction\AssertCheckShowMassActionPopup;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Manage POS - Mass action
 * Testcase MP12 - Delete POS
 *
 * Precondition
 * - Exist at least 1 record on the grid
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Tick on checkbox to select 1 POS on the grid
 * 3. Click on Mass action > Delete
 * 4. Click on [Cancel] button
 *
 * Acceptance
 * 1. Show a confirmation popup with message:
 * "Are you sure you want to delete selected items?" and 2 buttons: Cancel, OK
 * 2 .Close the confirmation popup, no record is deleted
 *
 * Class WebposManagePosMP12
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP12Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    private $assertShowPopup;

    public function __inject(PosIndex $posIndex, AssertCheckShowMassActionPopup $assertCheckShowMassActionPopup)
    {
        $this->posIndex = $posIndex;
        $this->assertShowPopup = $assertCheckShowMassActionPopup;
    }

    public function test(Pos $pos)
    {
        $pos->persist();
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $filter = [
            [
                'pos_name' => $pos->getPosName()
            ]
        ];
        $this->posIndex->getPosGrid()->massaction($filter, 'Delete');
        $this->assertShowPopup->processAssert($this->posIndex);
        $this->posIndex->getModal()->getCancelButton()->click();
    }
}