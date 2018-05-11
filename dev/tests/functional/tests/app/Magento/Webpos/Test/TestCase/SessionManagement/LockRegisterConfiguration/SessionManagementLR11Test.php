<?php
/**
 * Created by PhpStorm.
 * User: Bang
 * Date: 3/16/2018
 * Time: 7:54 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\LockRegisterConfiguration;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;

class SessionManagementLR11Test extends Injectable
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
        $this->posEdit->getPosForm()->getSecurityPinField()->setValue('aa@3');
        $this->posEdit->getFormPageActions()->save();
        $this->assertTrue(
            $this->posEdit->getPosForm()->getSecurityPinError()->isVisible(),
            'Security pin require error message is not visible'
        );
        $this->assertEquals(
            'Please enter a valid number in this field.',
            $this->posEdit->getPosForm()->getSecurityPinError()->getText(),
            'Require field message is wrong.'
        );
    }
}