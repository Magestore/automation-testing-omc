<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 5/9/18
 * Time: 10:18 AM
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Sync\AssertItemUpdateSuccess;
/**
 * Class SynchronizationStep
 * @package Magento\Webpos\Test\TestStep
 */
class SynchronizationStep implements TestStepInterface
{
    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Assert Item Update Success
     * @var AssertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    /**
     * @param WebposIndex $webposIndex
     * @param AssertItemUpdateSuccess $assertItemUpdateSuccess
     */
    public function __construct(
        WebposIndex $webposIndex,
        AssertItemUpdateSuccess $assertItemUpdateSuccess
    ) {
        $this->webposIndex = $webposIndex;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
    }

    public function run()
    {
        // Go to Synchronization
        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->synchronization();
        sleep(2);
        $this->webposIndex->getSyncTabData()->getItemRowReloadButton("Order")->click();
        sleep(5);
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, "Order", $action);
    }
}