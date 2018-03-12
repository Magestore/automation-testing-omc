<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/12/2018
 * Time: 10:49 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class SessionManagementLR002Test extends Injectable
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
        $this->posEdit->getPosForm()->getIsAllowToLockField()->setValue('Yes');
        $this->posEdit->getPosForm()->waitForElementVisible('[name="pin"]');
        $this->assertEquals(
            'Please enter a 4-digit number only.',
            $this->posEdit->getPosForm()->getPinNote()->getText(),
            'Pin note message is wrong.'
        );
    }
}