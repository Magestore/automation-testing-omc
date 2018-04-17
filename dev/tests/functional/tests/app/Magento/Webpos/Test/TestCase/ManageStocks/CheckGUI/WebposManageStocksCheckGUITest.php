<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/03/2018
 * Time: 08:53
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\CheckGUI;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksCheckGUITest extends Injectable
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
		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(2);

	}
}