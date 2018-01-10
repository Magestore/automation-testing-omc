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
}