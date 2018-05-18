<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:24 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Edit;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

/**
 * Manage POS - Edit POS
 * Testcase MP24 - Check [Back] button
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Detail] button to edit the POS
 *
 * Acceptance
 * 2. Redirect to Edit POS page including:
 * - Buttons: Back, Delete, Reset, Save and continue edit, Save
 * - All fields are filled out correctly the data of that POS
 *
 *
 * Class WebposManagePosMP24
 * @package Magento\Webpos\Test\TestCase\Pos\Filter
 */
class WebposManagePosMP24Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    public function __inject(PosIndex $posIndex)
    {
        $this->posIndex = $posIndex;
    }

    public function test(Pos $pos)
    {
        //Precondition
        $pos->persist();

        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPosGrid()->searchAndOpen([
            'pos_name' => $pos->getPosName()
        ]);
    }
}