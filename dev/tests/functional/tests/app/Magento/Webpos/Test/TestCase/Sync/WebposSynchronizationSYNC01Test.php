<?php

/**
 * Created by PhpStorm.
 * User: ducvu
 * Date: 2/23/2018
 * Time: 3:28 PM
 */
namespace Magento\Webpos\Test\TestCase\Sync;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;

class WebposSynchronizationSYNC01Test extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;
    /**
     * @var
     */

    public function __prepare()
    {
        // Config: use system value for all field in Tax Config
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'default_payment_method_all_method']
//        )->run();
    }

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     *
     * @return void
     */
    public function test( FixtureFactory $fixtureFactory)
    {
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => $configData]
//        )->run();

        $staff = $this->objectManager->create(
            '\Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();


        $this->webposIndex->getCMenu()->synchronization();

        sleep(2);

    }

    public function tearDown()
    {
//        $this->objectManager->getInstance()->create(
//            'Magento\Config\Test\TestStep\SetupConfigurationStep',
//            ['configData' => 'default_payment_method']
//        )->run();
    }
}