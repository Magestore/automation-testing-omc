<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:38 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Edit;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Edit POS
 * Testcase MP38 - Check [Delete] button
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 *
 * Steps
 * 1. Go to backend > Manage POS
 * 2. Click on [Detail] button to edit the POS
 * 3. Click on [Delete] button
 * 4. Click on [OK] button on the confirmation popup
 *
 * Acceptance
 * 3. Delete POS successfully
 * 4. Back to Manage POS page and show message: "POS was successfully deleted"
 *
 *
 * Class WebposManagePosMP38
 * @package Magento\Webpos\Test\TestCase\Pos\Edit
 */
class WebposManagePosMP38Test extends Injectable
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
        $this->posNews->getPosForm()->waitLoader();
        $this->posNews->getFormPageActions()->delete();
        $this->posNews->getPosForm()->waitForElementVisible('#modal-content-18');
        \PHPUnit_Framework_Assert::assertTrue(
            $this->posNews->getPosForm()->getConfirmModal()->isVisible(),
            'Confirm modal Popup wasn\'t show'
        );
        $this->posNews->getModalsWrapper()->getOkButton()->click();
        $this->posIndex->getPosGrid()->waitLoader();
    }
}