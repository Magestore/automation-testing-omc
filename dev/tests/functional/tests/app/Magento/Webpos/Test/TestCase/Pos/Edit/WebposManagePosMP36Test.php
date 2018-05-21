<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:36 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Edit;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Edit POS
 * Testcase MP36 - Check [Delete] button
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 *
 * Steps
 * 1. Go to backend > Manage POS
 * 2. Click on [Detail] button to edit the POS
 * 3. Click on [Delete] button
 * 4. Click on [Cancel] button on the confirmation popup
 *
 * Acceptance
 * 3. Display a confirmation popup with message: "Are you sure you want to do this?" and 2 buttons: Cancel, OK
 * 4. Close the confirmation popup and still stay on the Edit POS page
 *
 *
 * Class WebposManagePosMP36
 * @package Magento\Webpos\Test\TestCase\Pos\Edit
 */
class WebposManagePosMP36Test extends Injectable
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

    /**
     * @param PosIndex $posIndex
     * @param PosNews $posNews
     */
    public function __inject(PosIndex $posIndex, PosNews $posNews)
    {
        $this->posIndex = $posIndex;
        $this->posNews = $posNews;
    }

    public function test()
    {
        //Precondition
//        $pos->persist();

        //Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->waitLoader();
        $this->posIndex->getPosGrid()->searchAndOpen([
            'pos_name' => 'Store POS'
        ]);
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getFormPageActions()->delete();
        $this->posNews->getPosForm()->waitForElementVisible('#modal-content-18');
        \PHPUnit_Framework_Assert::assertTrue(
            $this->posNews->getPosForm()->getConfirmModal()->isVisible(),
            'Confirm modal Popup wasn\'t show'
        );
        $this->posNews->getModalsWrapper()->getCancelButton()->click();
        $this->posNews->getPosForm()->waitForElementNotVisible('#modal-content-18');
        \PHPUnit_Framework_Assert::assertFalse(
            $this->posNews->getPosForm()->getConfirmModal()->isVisible(),
            'Confirm modal Popup still was show'
        );
    }
}