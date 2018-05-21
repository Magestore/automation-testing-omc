<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 15:41
 */

namespace Magento\Webpos\Test\TestCase\Setting\General;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebPOSCheckGUITabTest
 * @package Magento\Webpos\Test\TestCase\Setting\General
 */
class WebPOSCheckGUITabTest extends Injectable
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

    public function test($menuItem)
    {
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->general();
        sleep(1);
        $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->click();
        sleep(1);
    }
}
