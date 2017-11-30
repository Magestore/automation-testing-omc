<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:31
 */

namespace Magento\InventorySuccess\Test\TestCase\Form;
use Magento\Mtf\TestCase\Injectable;
use Magento\InventorySuccess\Test\Page\Adminhtml\SettingInventoryIndex;

class CheckSettingEntityForInventoryTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var SettingInventoryIndex $settingInventoryIndex
     */
    protected $settingInventoryIndex;

    public function __inject(
        SettingInventoryIndex $settingInventoryIndex
    ) {
        $this->settingInventoryIndex = $settingInventoryIndex;
    }
    public function test()
    {
        $this->settingInventoryIndex->open();
	    if (!$this->settingInventoryIndex->getBlockSettingConfiguation()->getStockControlSection()->isVisible()) {
	    	$this->settingInventoryIndex->getBlockSettingConfiguation()->openStockControlSection();
	    }
        sleep(2);
    }
}