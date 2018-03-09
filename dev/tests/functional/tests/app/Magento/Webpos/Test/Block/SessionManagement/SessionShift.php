<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 17:26
 */

namespace Magento\Webpos\Test\Block\SessionManagement;

use Magento\Mtf\Block\Block;
/**
 * Class SessionShift
 * @package Magento\Webpos\Test\Block\SessionManagement
 */
class SessionShift extends Block
{
    public function getButtonEndSession()
    {
        return $this->_rootElement->find('.btn-close-shift');
    }

    public function getOpenShiftButton() {
        return $this->_rootElement->find('[data-bind="afterRender:afterRenderOpenButton"]');
    }

}