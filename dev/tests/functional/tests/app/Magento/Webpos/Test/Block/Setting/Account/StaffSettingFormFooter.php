<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/02/2018
 * Time: 11:03
 */

namespace Magento\Webpos\Test\Block\Setting\Account;

use Magento\Mtf\Block\Block;
/**
 * Class StaffSettingFormFooter
 * @package Magento\Webpos\Test\Block\Setting
 */
class StaffSettingFormFooter extends Block
{
    public function getSaveButton()
    {
        return $this->_rootElement->find('button.btn-save-acc');
    }
}