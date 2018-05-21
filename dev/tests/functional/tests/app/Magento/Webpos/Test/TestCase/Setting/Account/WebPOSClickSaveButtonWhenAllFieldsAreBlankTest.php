<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 13:16
 */

namespace Magento\Webpos\Test\TestCase\Setting\Account;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebPOSClickSaveButtonWhenAllFieldsAreBlankTest
 * @package Magento\Webpos\Test\TestCase\Setting\Account
 */
class WebPOSClickSaveButtonWhenAllFieldsAreBlankTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->account();
        sleep(1);
        $this->webposIndex->getStaffSettingFormMainAccount()->getDisplayName()->setValue('');
        $this->webposIndex->getStaffSettingFormFooter()->getSaveButton()->click();
    }
}