<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/2/18
 * Time: 9:40 AM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\CheckLockUnlockButton;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
/**
 * Class CheckPositionLockUnlockButtonLR15Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckLockUnlockButton
 * Pre-condition:
 *   LoginTest backend with account has been assigned the permission to lock/unlock  register
 *   Go to Sales > Web POS > Manage POS > Open an any POS -> and set the Enable option to lock register to  Yes
 * Step:
 *   On the POS page, observe position of the Lock/Unlock button
 * Acceptance Criteria:
 *   The Lock/Unlock button is located between the Reset and Save and continue edit button
 */
class CheckPositionLockUnlockButtonLR15Test extends Injectable
{
    /**
     * Webpos Pos Index page.
     *
     * @var PosIndex
     */
    private $posIndex;

    /**
     * Edit Pos Group page.
     *
     * @var PosEdit
     */
    private $posEdit;
    private $posName;

    /**
     * Inject Pos pages.
     *
     * @param PosIndex $posIndex
     * @param PosNews $posNew
     * @return void
     */
    public function __inject(
        PosIndex $posIndex,
        PosEdit $posEdit
    ) {
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
    }

    /**
     * Create Pos group test.
     *
     * @param Pos $pos
     * @return void
     */
    public function test(Pos $pos, $pos_name, $is_allow_to_lock, $pin)
    {
        // Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->resetFilter();
        $this->posIndex->getPosGrid()->searchAndOpen(['pos_name' => $pos_name]);
        $this->posEdit->getPosForm()->getIsAllowToLockField()->setValue($is_allow_to_lock);
        $this->posEdit->getPosForm()->getSecurityPinField()->setValue($pin);
        $this->posEdit->getFormPageActions()->saveAndContinue();
        $this->assertTrue(
            $this->posEdit->getFormPageActions()->getLockButton()->isVisible(),
            'Lock Button is not visible.'
        );
        $this->assertEquals(
            $this->posEdit->getFormPageActions()->getLockButton()->getText(),
            'Lock',
            'Lock Button is not visible.'
        );
        $this->posEdit->getFormPageActions()->save();
        $this->assertTrue(
            $this->posIndex->getMessagesBlock()->isVisible(),
            'Alert message is not visible.'
        );
        $this->assertEquals(
            'Pos was successfully saved',
            $this->posIndex->getMessagesBlock()->getSuccessMessage(),
            'Success message is wrong.'
        );

        $this->posName = $pos_name;
    }

    public function tearDown()
    {
        // Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->resetFilter();
        $this->posIndex->getPosGrid()->searchAndOpen(['pos_name' => $this->posName]);
        $this->posEdit->getPosForm()->getIsAllowToLockField()->setValue('No');
        $this->posEdit->getFormPageActions()->save();
        $this->assertTrue(
            $this->posIndex->getMessagesBlock()->isVisible(),
            'Alert message is not visible.'
        );
        $this->assertEquals(
            'Pos was successfully saved',
            $this->posIndex->getMessagesBlock()->getSuccessMessage(),
            'Success message is wrong.'
        );
    }
}
