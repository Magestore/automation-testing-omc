<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/14/2018
 * Time: 8:32 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class SessionManagementLR06Test extends Injectable
{
    /**
     * @var PosIndex
     */
    protected $posIndex;

    /**
     * @var PosEdit
     */
    protected $posEdit;

    public function __inject(PosIndex $posIndex, PosEdit $posEdit)
    {
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
    }

    public function test(Pos $pos)
    {
        $pos->persist();
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->searchAndOpen(['pos_name' => $pos->getPosName()]);
        $this->posEdit->getPosForm()->getIsAllowToLockField()->setValue('No');
        $this->posEdit->getFormPageActions()->saveAndContinue();
        $data = $this->posEdit->getPosForm()->getStatusFieldData();
        $this->assertTrue(
            strpos($data, 'Locked') == false,
            'Option Locked in Status field is not hidden.'
        );
    }
}