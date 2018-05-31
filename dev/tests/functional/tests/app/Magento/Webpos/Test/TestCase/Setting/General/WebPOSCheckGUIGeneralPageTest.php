<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 14:52
 */

namespace Magento\Webpos\Test\TestCase\Setting\General;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSCheckGUIGeneralPageTest
 * @package Magento\Webpos\Test\TestCase\Setting\General
 * Precondition and setup steps
 * 1. Login webpos as a staff
 * Steps
 * 1. Click on [General] menu
 * Acceptance Criteria
 * 1. Redirect to General page with 4 tabs: Checkout, Catalog, Currency, POS Hub
 */
class WebPOSCheckGUIGeneralPageTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
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
        $this->webposIndex->getCMenu()->general();
        sleep(1);
    }
}
