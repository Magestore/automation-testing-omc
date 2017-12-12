<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 10:22
 */
namespace  Magento\Webpos\Test\TestStep;

use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Mtf\Config\DataInterface;

/**
 * Class LoginWebposStep
 * @package Magento\Webpos\Test\TestStep
 */
class LoginWebposStep implements TestStepInterface
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
     * @param WebposIndex $webposIndex
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

    public function run()
    {
        $username = $this->configuration->get('application/0/backendLogin/0/value');
        $password = $this->configuration->get('application/0/backendPassword/0/value');
        $this->webposIndex->open();
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $this->webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            sleep(3);
            while ($this->webposIndex->getFirstScreen()->isVisible()) {}
            sleep(2);
        }

        $data = [
            'username' => $username,
            'password' => $password
        ];
        return $this->fixtureFactory->createByCode('staff' , ['data' => $data]);
    }
}