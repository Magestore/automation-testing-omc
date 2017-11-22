<?php
/**
 * Created By thomas
 * Created At 13:55
 * Email: thomas@trueplus.vn
 * Last Modified by: ${MODIFIED_BY}
 * Last Modified time: ${MODIFIED_TIME}
 * Links: https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\Block;

use Magento\Mtf\Block\Block;

class PageLayoutWebpos extends Block
{
    public function getErrorSearchText()
    {
        return $this->_rootElement->find('div.modals-wrapper > aside > div.modal-inner-wrap > div > div');
    }

}