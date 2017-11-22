<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/09/2017
 * Time: 10:38
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Location;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\Adminhtml\LocationIndex;
use Magento\Webpos\Test\Page\Adminhtml\LocationNews;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksUpdateMS12Test extends Injectable
{
	protected $webposIndex;
	protected $locationIndex;
	protected $locationNews;

	public function __inject(
		WebposIndex $webposIndex,
		LocationIndex $locationIndex,
		LocationNews $locationNews
	)
	{
		$this->webposIndex = $webposIndex;
		$this->locationIndex = $locationIndex;
		$this->locationNews = $locationNews;
	}

	public function test(Staff $staff, Location $location)
	{

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();

		$name = $productName = $this->webposIndex->getManageStocks()->getLocationName();

		$filter = ['display_name' => $name];
		$this->locationIndex->open();
		$this->locationIndex->getLocationsGrid()->searchAndOpen($filter);
		$this->locationNews->getLocationsForm()->fill($location);
		$this->locationNews->getFormPageActions()->save();

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
			$this->webposIndex->getLoginForm()->fill($staff);
			$this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(15);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();

		sleep(1);
		self::assertEquals(
			$location->getDisplayName(),
			$this->webposIndex->getManageStocks()->getLocationName(),
			"MS12 - Location's name is not updated "
		);
		self::assertEquals(
			$location->getAddress(),
			$this->webposIndex->getManageStocks()->getLocationAddress(),
			"MS12 - Location's address is not updated "
		);
	}
}
