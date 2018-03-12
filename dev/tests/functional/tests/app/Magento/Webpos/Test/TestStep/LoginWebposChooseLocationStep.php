<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 3/8/2018
 * Time: 2:03 PM
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Mtf\Config\DataInterface;

/**
 * Class LoginWebposChooseLocationStep
 * @package Magento\Webpos\Test\TestStep
 */
class LoginWebposChooseLocationStep implements TestStepInterface
{
    /**
     * System config.
     *
     * @var DataInterface
     */
    protected $configuration;

    /**
     * Webpos Index page.
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var FixtureFactory
     */
    protected $fixtureFactory;

    /**
     * LoginWebposChooseLocationStep constructor.
     * @param WebposIndex $webposIndex
     * @param DataInterface $configuration
     * @param FixtureFactory $fixtureFactory
     */
    public function __construct(
        WebposIndex $webposIndex,
        DataInterface $configuration,
        FixtureFactory $fixtureFactory
    ) {
        $this->webposIndex = $webposIndex;
        $this->configuration = $configuration;
        $this->fixtureFactory = $fixtureFactory;
    }

    /**
     * @return \Magento\Mtf\Fixture\FixtureInterface|mixed
     */
    public function run()
    {
        $username = $this->configuration->get('application/0/backendLogin/0/value');
        $password = $this->configuration->get('application/0/backendPassword/0/value');
        $this->webposIndex->open();
        $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');

            // Choose Location: Store Address and Pos: Store POS
            $this->webposIndex->getLoginForm()->setLocation('Store Address');
            $this->webposIndex->getLoginForm()->setPos('Store POS');
            $this->webposIndex->getLoginForm()->getEnterToPos()->click();

            $this->webposIndex->getMsWebpos()->waitForElementNotVisible('.loading-mask');
            $this->webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($this->webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $data = [
            'username' => $username,
            'password' => $password
        ];
        return $this->fixtureFactory->createByCode('staff' , ['data' => $data]);
    }
}