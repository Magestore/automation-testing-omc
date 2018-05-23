<?php
/**
 * Created by PhpStorm.
 * User: stephen
 * Date: 5/14/18
 * Time: 4:34 PM
 */

namespace Magento\Webpos\Test\TestCase\Pos\Edit;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Manage POS - Edit POS
 * Testcase MP34 - Check [Save and continue edit] button
 *
 * Precondition
 * - Exist at least 1 POS on the grid of Manage POS page
 *
 * Steps
 * 1. Go to backend > Manage POS
 * 2. Click on [Detail] button to edit the POS
 * 3. Edit correctly some fields
 * 4. Click on [Save and continue edit] button
 *
 * Acceptance
 * - Edit POS successfully
 * - Show message: "POS was successfully saved"
 *
 * Class WebposManagePosMP34
 * @package Magento\Webpos\Test\TestCase\Pos\Edit
 */
class WebposManagePosMP34Test extends Injectable
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

    public function test(Pos $pos, $posName)
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
        $this->posNews->getPosForm()->setPosName($posName);
        $this->posNews->getFormPageActions()->saveAndContinue();
        \PHPUnit_Framework_Assert::assertEquals(
            $posName,
            $this->posNews->getPosForm()->getGeneralFieldById('page_pos_name')->getValue(),
            'POS wasn\'t successfully saved '
        );
    }

}