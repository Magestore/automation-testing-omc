<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:25 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Edit;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Edit POS
 * Testcase MP25 - Check [Save] button without editing
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 *
 * Steps
 * 1. Go to backend > Sales > Manage POS
 * 2. Click on [Detail] button to edit the POS
 * 3.  Click on [Save] button
 *
 * Acceptance
 * 3. Back to the Manage POS page
 * - Show message: "POS was successfully saved"
 * - The information of that POS is changless
 *
 *
 * Class WebposManagePosMP25
 * @package Magento\Webpos\Test\TestCase\Pos\Edit
 */
class WebposManagePosMP25Test extends Injectable
{
    /**
     * Pos Index Page
     *
     * @var $posIndex
     */
    private $posIndex;

    /**
     * Pos New page
     *
     * @var $posNews
     */
    private $posNews;

    public function __inject(PosIndex $posIndex, PosNews $posNews)
    {
        $this->posIndex = $posIndex;
        $this->posNews = $posNews;
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
        $this->posNews->getFormPageActions()->save();
        $this->posIndex->getPosGrid()->waitLoader();
    }
}