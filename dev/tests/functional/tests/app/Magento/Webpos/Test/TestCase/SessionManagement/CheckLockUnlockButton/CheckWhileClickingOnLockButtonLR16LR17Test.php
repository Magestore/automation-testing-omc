<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/2/18
 * Time: 1:53 PM
 */

namespace Magento\Webpos\Test\TestCase\SessionManagement\CheckLockUnlockButton;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Pos;
use Magento\Webpos\Test\Page\Adminhtml\PosIndex;
use Magento\Webpos\Test\Page\Adminhtml\PosEdit;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class CheckWhileClickingOnLockButtonLR16LR17Test
 * @package Magento\Webpos\Test\TestCase\SessionManagement\CheckLockUnlockButton
 * Precondition and setup steps
 *   LoginTest backend with account has been assigned the permission to lock/unlock register
 *   Go to Sales > Web POS > Manage POS > Open an any POS
 *   set the Enable option to lock register field to Yes
 * Steps
 *   Select an opening POS
 *   LR16
 *   In POS page, click on Lock button
 *   LR17
 *   In POS page, click on Unlock button
 *   Refresh webpos page
 * Acceptance Criteria
 *   In backend, show message ""(POS NAME) was locked successfully""  and simultaneously the Lock button is changed to Unlock button
 *   On webpos show lock screen
 */
class CheckWhileClickingOnLockButtonLR16LR17Test extends Injectable
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
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Inject Pos pages.
     *
     * @param PosIndex $posIndex
     * @param PosNews $posNew
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex,
        PosIndex $posIndex,
        PosEdit $posEdit
    ) {
        $this->webposIndex = $webposIndex;
        $this->posIndex = $posIndex;
        $this->posEdit = $posEdit;
    }

    /**
     * Create Pos group test.
     *
     * @param Pos $pos
     * @return void
     */
    public function test($pos_name, $is_allow_to_lock, $pin, $testId)
    {

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        // Steps
        $this->posIndex->open();
        $this->posIndex->getPosGrid()->resetFilter();
        $this->posIndex->getPosGrid()->searchAndOpen(['pos_name' => $pos_name]);
        $this->posEdit->getPosForm()->getIsAllowToLockField()->setValue($is_allow_to_lock);
        $this->posEdit->getPosForm()->getSecurityPinField()->setValue($pin);
        $this->posEdit->getFormPageActions()->saveAndContinue();
        $this->assertEquals(
            'Pos was successfully saved',
            $this->posIndex->getMessagesBlock()->getSuccessMessage(),
            'Success message is wrong.'
        );
        $this->assertTrue(
            $this->posEdit->getFormPageActions()->getLockButton()->isVisible(),
            'Lock Button is not visible.'
        );
        $this->assertEquals(
            $this->posEdit->getFormPageActions()->getLockButton()->getText(),
            'Lock',
            'Lock Button is not visible.'
        );
        if ($this->posEdit->getFormPageActions()->getLockButton()->isVisible() && $testId=='LR15') {
            $this->posEdit->getFormPageActions()->getLockButton()->click();
            $this->assertEquals(
                'Store POS was locked successfully.',
                $this->posIndex->getMessagesBlock()->getSuccessMessage(),
                'Success lock message is wrong.'
            );
            $this->assertEquals(
                $this->posEdit->getFormPageActions()->getUnlockButton()->getText(),
                'Unlock',
                'Lock Button was not change to Unlock Button.'
            );
        } elseif ($this->posEdit->getFormPageActions()->getUnlockButton()->isVisible() && $testId=='LR16') {
            $this->posEdit->getFormPageActions()->getUnlockButton()->click();
            $this->assertEquals(
                'Store POS was unlocked successfully.',
                $this->posIndex->getMessagesBlock()->getSuccessMessage(),
                'Success unlock message is wrong.'
            );
            $this->posIndex->getPosGrid()->resetFilter();
            $this->posIndex->getPosGrid()->searchAndOpen(['pos_name' => $pos_name]);
            $this->assertEquals(
                $this->posEdit->getFormPageActions()->getLockButton()->getText(),
                'Unlock',
                'Lock Button was not change to Unlock Button.'
            );
        }
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

        $this->webposIndex->open();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();

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
