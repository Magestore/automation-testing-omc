<?php
/**
 * Created by PhpStorm.
 * User: finbert
 * Date: 25/05/2018
 * Time: 10:29
 */

namespace Magento\Webpos\Test\Block\Adminhtml\SystemConfig;

use Magento\Backend\Test\Block\System\Config\Form;
use Magento\Mtf\Client\Locator;

/**
 * Class WebposSystemConfigForm
 * @package Magento\Webpos\Test\Block\Adminhtml\SystemConfig
 */
class WebposSystemConfigForm extends Form
{
    public function waitForTableContentSecurity()
    {
        $this->waitForElementVisible('//*[@id="webpos_security"]/table]', Locator::SELECTOR_XPATH);
    }

    public function getTableContentSecurity()
    {
        return $this->_rootElement->find('#webpos_security');
    }

    public function getPOSAccountSharingLabel()
    {
        return $this->getTableContentSecurity()->find('//*[text()="POS Account Sharing"]', Locator::SELECTOR_XPATH);
    }

    public function getPOSAccountSharingDropdown()
    {
        return $this->_rootElement->find('#webpos_security_pos_account_sharing', Locator::SELECTOR_CSS, 'select');
    }

    public function getPOSAccountSharingTextGuide()
    {
        return $this->_rootElement->find('#webpos_security .note > span');
    }
}