<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 10:48
 */

namespace Magento\Webpos\Test\TestCase\Setting\Account;

use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSCheckGUIMyAccountPageTest
 * @package Magento\Webpos\Test\TestCase\Setting\Account
 */
class WebPOSCheckGUIMyAccountPageTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * System config.
     *
     * @var DataInterface
     */
    protected $configuration;

    /**
     * @param DataInterface $configuration
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        DataInterface $configuration,
        WebposIndex $webposIndex
    )
    {
        $this->configuration = $configuration;
        $this->webposIndex = $webposIndex;
    }

    public function test()
    {
        $username = $this->configuration->get('application/0/backendLogin/0/value');
        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->account();
        sleep(1);
        return [
            'username' => $username
        ];
    }
}