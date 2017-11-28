<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 10:44
 */
namespace Magento\PurchaseOrderSuccess\Test\TestCase\Form;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SettingSupplierConfigurationIndex;

class CheckSettingEntityForSupplierConfigurationTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var SettingSupplierConfigurationIndex $settingSupplierConfigurationIndex
     */
    protected $settingSupplierConfigurationIndex;

    public function __inject(
        SettingSupplierConfigurationIndex $settingSupplierConfigurationIndex
    ) {
        $this->settingSupplierConfigurationIndex = $settingSupplierConfigurationIndex;
    }
    public function test()
    {
        $this->settingSupplierConfigurationIndex->open();
        sleep(2);
    }
}