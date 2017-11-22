<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 10:52:14
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:24:56
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Pos;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosNews;

/**
 * Steps:
 * 1. Log in to Admin.
 * 2. Open the Sales -> Pos Manage page.
 * 3. Click the "New Pos" button.
 * 4. Enter data according to a data set. For each variation, the pos must have unique identifiers.
 * 5. Click the "Save Pos Group" button.
 * 6. Verify the Pos group saved successfully.
 */
class CreatePosEntityTest extends Injectable
{
    /**
     * Webpos Pos Index page.
     *
     * @var PosIndex
     */
    private $posIndex;

    /**
     * New Pos Group page.
     *
     * @var PosNews
     */
    private $posNew;

    /**
     * Inject Pos pages.
     *
     * @param PosIndex $posIndex
     * @param PosNews $posNew
     * @return void
     */
    public function __inject(
        PosIndex $posIndex,
        PosNews $posNew
    ) {
        $this->posIndex = $posIndex;
        $this->posNew = $posNew;
    }

    /**
     * Create Pos group test.
     *
     * @param Pos $pos
     * @return void
     */
    public function test(Pos $pos)
    {
        // Steps
        $this->posIndex->open();
        $this->posIndex->getPageActionsBlock()->addNew();
        $this->posNew->getPosForm()->fill($pos);
        $this->posNew->getFormPageActions()->save();
    }
}
