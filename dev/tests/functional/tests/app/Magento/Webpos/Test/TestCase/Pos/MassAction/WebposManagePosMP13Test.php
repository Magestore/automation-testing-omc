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
 * Testcase MP13 - Delete 1 POS
 *
 * Precondition
 * - Exist at least 1 record on the grid
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Tick on checkbox to select 1 POS on the grid
 * 3. Click on Mass action > Delete
 * 4. Click on [OK] button
 *
 * Acceptance
 * 1. Close the confirmation popup
 * 2. Delete the selected POS successfully and show message: "A total of 1 record(s) were deleted
 *
 * Class WebposManagePosMP13
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP13Test extends Injectable
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
        $filters = [
            [
                'pos_name' => $pos->getPosName()
            ]
        ];
        $this->posIndex->getPosGrid()->massaction($filters, 'Delete', true);
        return [
            'filters' => $filters,
            'itemCount' => 1
        ];
    }
}