<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 10:09
 */

namespace Magento\Webpos\Test\Block\Checkout;

use Magento\Mtf\Block\Block;
/**
 * Class CheckoutShippingMethod
 * @package Magento\Webpos\Test\Block\CategoryRepository
 */
class CheckoutShippingMethod extends Block
{
    public function clickFlatRateFixedMethod()
    {
        $this->_rootElement->click();
        $this->_rootElement->find('[id="flatrate_flatrate"]')->click();
    }

	public function clickShipPanel()
	{
		$this->_rootElement->click();
	}

	public function getFlatRateFixed()
	{
		return $this->_rootElement->find('#flatrate_flatrate');
	}

	public function getBestWayTableRate()
	{
		return $this->_rootElement->find('#tablerate_bestway');
	}

	public function getStorePickupStorePickup()
	{
		return $this->_rootElement->find('#storepickup_storepickup');
	}

	public function getPOSShippingStorePickup()
	{
		return $this->_rootElement->find('#webpos_shipping_storepickup');
	}

	public function getShippingMethod()
    {
        return $this->_rootElement->find('#shipping-method');
    }
}