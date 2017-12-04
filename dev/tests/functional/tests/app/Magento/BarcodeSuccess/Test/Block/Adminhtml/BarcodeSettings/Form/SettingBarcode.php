<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:07
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeSettings\Form;
use Magento\Mtf\Block\Block;

class SettingBarcode extends Block
{
    public function isVisibleForm($idForm)
    {
        $idForm = '#'.$idForm;
        return $this->_rootElement->find($idForm)->isVisible();
    }
    public function isFirstFieldFormVisible($idFirstField)
    {
        $idFirstField = '#'.$idFirstField;
        return $this->_rootElement->find($idFirstField)->isVisible();
    }
    public function getNameConfigurationBarcode($pathNameConfiguration){
        return $this->_rootElement->find($pathNameConfiguration)->getText();
    }

	public function getGeneralSection($idGeneralSection)
	{
        $idGeneralSection = '#'.$idGeneralSection;
		return $this->_rootElement->find($idGeneralSection);
	}

	public function openGeneralSection($idHeadOpen)
	{
        $idHeadOpen = '#'.$idHeadOpen;
        $this->_rootElement->find($idHeadOpen)->click();
	}

}