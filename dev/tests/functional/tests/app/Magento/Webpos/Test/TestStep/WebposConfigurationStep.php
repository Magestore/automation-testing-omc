<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 08/12/2017
 * Time: 16:32
 */

namespace Magento\Webpos\Test\TestStep;

use Magento\Backend\Test\Page\Adminhtml\SystemConfigEdit;
use Magento\Config\Test\Fixture\ConfigData;
use Magento\Mtf\TestStep\TestStepInterface;

/**
 * Class WebposConfigurationStep
 * @package Magento\Webpos\Test\TestStep
 */
class WebposConfigurationStep implements TestStepInterface
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

    private $dataConfig;

    /**
     * @param SystemConfigEdit $systemConfigEdit
     */
    public function __construct(
        SystemConfigEdit $systemConfigEdit,
        ConfigData $dataConfig
    )
    {
        $this->systemConfigEdit = $systemConfigEdit;
        $this->dataConfig = $dataConfig;
    }

    /**
     * Open backend system config and set configuration values.
     *
     * @param SystemConfigEdit $systemConfigEdit
     * @param ConfigData $dataConfig
     * @return void
     */
    public function run()
    {
        $this->systemConfigEdit->open();
        $section = $this->dataConfig->getSection();
        $keys = array_keys($section);
        foreach ($keys as $key) {
            $parts = explode('/', $key, 3);
            $tabName = $parts[0];
            $groupName = $parts[1];
            $fieldName = $parts[2];
            $this->systemConfigEdit->getForm()->getGroup($tabName, $groupName)
                ->setValue($tabName, $groupName, $fieldName, $section[$key]['label']);
        }
        $this->systemConfigEdit->getPageActions()->save();
    }
}