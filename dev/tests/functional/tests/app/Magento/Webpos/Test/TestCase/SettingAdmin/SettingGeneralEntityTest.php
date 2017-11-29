<?php

/**
 * @Author: thomas
 * @Created At:   2017-09-13 08:23:03
 * @Email:  thomas@trueplus.vn
 * @Last Modified by:   thomas
 * @Last Modified time: 2017-10-11 10:17:45
 * @Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\SettingAdmin;

use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\TestCase\Injectable;

class SettingGeneralEntityTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * New System Config Edit page.
     *
     * @var SystemConfigEdit
     */
    private $systemConfigEdit;

    /**
     * Inject System Config Edit pages.
     * @param SystemConfigEdit $systemConfigEdit
     * @return void
     */
    public function __inject(
        SystemConfigEdit $systemConfigEdit
    ) {
        $this->systemConfigEdit = $systemConfigEdit;
    }

    /**
     * Open backend system config and set configuration values.
     *
     * @param SystemConfigEdit $systemConfigEdit
     * @param ConfigData $dataConfig
     * @return void
     */
    public function test(SystemConfigEdit $systemConfigEdit, ConfigData $dataConfig)
    {
        $systemConfigEdit->open();
        $section = $dataConfig->getSection();
        $keys = array_keys($section);
        foreach ($keys as $key) {
            $parts = explode('/', $key, 3);
            $tabName = $parts[0];
            $groupName = $parts[1];
            $fieldName = $parts[2];
            $systemConfigEdit->getForm()->getGroup($tabName, $groupName)
                ->setValue($tabName, $groupName, $fieldName, $section[$key]['label']);
        }
        $this->systemConfigEdit->getPageActions()->save();
    }
}
