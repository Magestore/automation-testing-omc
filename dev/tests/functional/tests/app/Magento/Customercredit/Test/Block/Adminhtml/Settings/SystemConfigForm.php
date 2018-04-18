<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/29/2017
 * Time: 9:39 AM
 */

namespace Magento\Customercredit\Test\Block\Adminhtml\Settings;

use Magento\Backend\Test\Block\System\Config\Form;
use Magento\Mtf\Client\Locator;

class SystemConfigForm extends Form
{
    protected $sectionConfigTemplate = './/div[contains(@class,"section-config")]/div/a[text()="%s"]';

    public function getSectionConfigByName($sectionName)
    {
        return $this->_rootElement->find(sprintf($this->sectionConfigTemplate, $sectionName), Locator::SELECTOR_XPATH);
    }
}