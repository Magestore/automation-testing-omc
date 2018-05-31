<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 23/02/2018
 * Time: 08:40
 */

namespace Magento\Webpos\Test\TestCase\Setting\Login;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSLoginSuccessfulyTest
 * @package Magento\Webpos\Test\TestCase\Setting\LoginTest
 */
class WebPOSLoginSuccessfulyTest extends Injectable
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
    }
}