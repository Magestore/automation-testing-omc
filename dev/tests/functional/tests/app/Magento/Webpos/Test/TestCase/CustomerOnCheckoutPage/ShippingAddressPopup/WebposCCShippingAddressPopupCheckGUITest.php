<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/02/2018
 * Time: 08:13
 */

namespace Magento\Webpos\Test\TestCase\CustomerOnCheckoutPage\ShippingAddressPopup;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposCCShippingAddressPopupCheckGUITest extends Injectable
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

	public function test(
		$action = ''
	)
	{
		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
		$this->webposIndex->getMsWebpos()->waitCartLoader();

		$this->webposIndex->getCheckoutCartHeader()->getIconAddCustomer()->click();
		$this->webposIndex->getCheckoutChangeCustomer()->waitForCustomerList();

		$this->webposIndex->getCheckoutChangeCustomer()->getAddNewCustomerButton()->click();
		sleep(1);
		$this->webposIndex->getCheckoutAddCustomer()->getAddShippingAddressIcon()->click();
		sleep(1);


		if (strcmp($action, 'cancel') == 0) {
			$this->webposIndex->getCheckoutAddShippingAddress()->getCancelButton()->click();
		} elseif (strcmp($action, 'save') == 0) {
			$this->webposIndex->getCheckoutAddShippingAddress()->getSaveButton()->click();
		}
	}
}