<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/12/2018
 * Time: 1:12 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class SessionManagementLR003Test extends Injectable
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
        $value = $this->posEdit->getPosForm()->getIsAllowToLockField()->getValue();
        $this->assertEquals(
            'No',
            $value,
            'Lock register default value is wrong.'
        );
    }
}