<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:31
 */

namespace Magento\PurchaseOrderSuccess\Test\TestCase\Form;
use Magento\Mtf\TestCase\Injectable;
use Magento\PurchaseOrderSuccess\Test\Page\Adminhtml\SettingPurchaseManagementIndex;

class CheckSettingEntityForPurchaseManagementTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var SettingPurchaseManagementIndex $settingPurchaseManagementIndex
     */
    protected $settingPurchaseManagementIndex;

    public function __inject(
        SettingPurchaseManagementIndex $settingPurchaseManagementIndex
    ) {
        $this->settingPurchaseManagementIndex = $settingPurchaseManagementIndex;
    }
    public function test()
    {
        $this->settingPurchaseManagementIndex->open();
        sleep(2);
    }
}