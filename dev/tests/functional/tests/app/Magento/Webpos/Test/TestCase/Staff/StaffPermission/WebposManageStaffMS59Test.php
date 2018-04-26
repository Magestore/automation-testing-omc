<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 12/02/2018
 * Time: 09:14
 */
namespace Magento\Webpos\Test\TestCase\Staff\StaffPermission;
use Magento\Mtf\Fixture;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\WebposRole;
use Magento\Webpos\Test\Page\WebposIndex;
class WebposManageStaffMS59Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    private $webposIndex;

    public function __prepare()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'have_shipping_method_on_webpos_CP197']
        )->run();
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_yes_MS57']
        )->run();
    }

    /**
     * Inject WebposIndex pages.
     *
     * @param $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    ) {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Create WebposRole group test.
     *
     * @param WebposRole
     * @return void
     */
    public function test(WebposRole $webposRole, Fixture\FixtureFactory $fixtureFactory,  $products)
    {
        /*Create pos and location*/
        $pos = $fixtureFactory->createByCode('pos', ['dataset' => 'MS57Staff']);
        $pos->persist();
        $dataLocation = $pos->getDataFieldConfig('location_id')['source']->getLocation()->getData();
        $webposRole->persist();
        $staff = $fixtureFactory->createByCode('staff', ['dataset' => 'staffMS21']);
        $dataStaff = $staff->getData();
        $dataStaff['location_id'] = [$dataLocation['location_id']];
        $dataStaff['pos_ids'] = [$pos->getData('pos_id')];
        $dataStaff['role_id'] = $webposRole->getRoleId();
        $staff = $fixtureFactory->createByCode('staff', ['data' => $dataStaff]);
        $staff->persist();

        //Login
        $this->loginWebpos($this->webposIndex, $dataStaff['username'],$dataStaff['password'], $dataLocation['display_name'], $pos->getData('pos_name'));
        sleep(3);
    }

    public function loginWebpos(WebposIndex $webposIndex, $username, $password, $locationName, $posName)
    {
        $webposIndex->open();
        if ($webposIndex->getLoginForm()->isVisible()) {
            $webposIndex->getLoginForm()->getUsernameField()->setValue($username);
            $webposIndex->getLoginForm()->getPasswordField()->setValue($password);
            $webposIndex->getLoginForm()->clickLoginButton();
            $webposIndex->getMsWebpos()->waitForElementNotVisible('#checkout-loader');
            $webposIndex->getMsWebpos()->waitForElementVisible('[id="webpos-location"]');
            $webposIndex->getLoginForm()->setLocation($locationName);
            $webposIndex->getLoginForm()->setPos($posName);
            $webposIndex->getLoginForm()->getEnterToPos()->click();
            sleep(3);
            //			$this->webposIndex->getMsWebpos()->waitForSyncDataAfterLogin();
            $webposIndex->getMsWebpos()->waitForSyncDataVisible();
            $time = time();
            $timeAfter = $time + 360;
            while ($webposIndex->getFirstScreen()->isVisible() && $time < $timeAfter){
                $time = time();
            }
            sleep(2);
        }
        $webposIndex->getCheckoutProductList()->waitProductListToLoad();
        if($this->webposIndex->getOpenSessionPopup()->isOpenSessionDisplay())
        {
            $this->webposIndex->getOpenSessionPopup()->getOpenSessionButton()->click();
            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->checkout();
        }
        sleep(2);
        $this->webposIndex->getOpenSessionPopup()->getCancelButton()->click();
    }
    public function tearDown()
    {
        $this->objectManager->getInstance()->create(
            'Magento\Config\Test\TestStep\SetupConfigurationStep',
            ['configData' => 'create_section_before_working_no_MS57']
        )->run();
    }
}

