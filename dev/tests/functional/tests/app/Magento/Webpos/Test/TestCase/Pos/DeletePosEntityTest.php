<?php

/**
 * @Author: Thomas Mr 0
 * @Created At:   2017-09-08 13:13:04
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-06 11:25:01
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Pos;

use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Mtf\TestCase\Injectable;

/**
 * Preconditions:
 * 1. Create Webpos Pos.
 *
 * Steps:
 * 1. Login to backend.
 * 2. Open Sales -> Webpos -> Manage Pos.
 * 3. Open Pos from preconditions.
 * 4. Delete.
 * 5. Perform all asserts.
 *
 * @group Pos(PS)
 * @ZephyrId MAGETWO-28459
 */
class DeletePosEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'CS';
    /* end tags */

    /**
     * @var PosIndex
     */
    protected $posIndexPage;

    /**
     * @var PosEdit
     */
    protected $posEditPage;

    /**
     * Preparing pages for test
     *
     * @param PosIndex $posIndexPage
     * @param PosEdit $posEditPage
     * @return void
     */
    public function __inject(
        PosIndex $posIndexPage,
        PosEdit $posEditPage
    )
    {
        $this->posIndexPage = $posIndexPage;
        $this->posEditPage = $posEditPage;
    }

    /**
     * Runs Delete Pos Backend Entity test
     *
     * @param Pos $pos
     * @return void
     */
    public function testDeletePosEntity(Pos $pos)
    {
        // Preconditions:
        $pos->persist();

        // Steps:
        $filter = ['pos_name' => $pos->getPosName()];
        $this->posIndexPage->open();
        $this->posIndexPage->getPosGrid()->searchAndOpen($filter);
        $this->posEditPage->getFormPageActions()->delete();
        $this->posEditPage->getModalBlock()->acceptAlert();
    }
}
