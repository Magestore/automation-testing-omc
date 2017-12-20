<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 28/11/2017
 * Time: 09:07
 */

namespace Magento\BarcodeSuccess\Test\Block\Adminhtml\BarcodeSettings\Form;
use Magento\Mtf\Block\Form;

class SettingsBarcode extends Form
{
    /**
     * @param $idForm
     * @return bool
     */
    public function isVisibleForm($idForm)
    {
        $idForm = '#'.$idForm;
        return $this->_rootElement->find($idForm)->isVisible();
    }

    /**
     * @param $idFirstField
     * @return bool
     */
    public function isFirstFieldFormVisible($idFirstField)
    {
        $idFirstField = '#'.$idFirstField;
        return $this->_rootElement->find($idFirstField)->isVisible();
    }

    /**
     * @param $pathNameConfiguration
     * @return array|string
     */
    public function getNameConfigurationBarcode($pathNameConfiguration){
        return $this->_rootElement->find($pathNameConfiguration)->getText();
    }

    /**
     * @param $idGeneralSection
     * @return \Magento\Mtf\Client\ElementInterface
     */
	public function getGeneralSection($idGeneralSection)
	{
        $idGeneralSection = '#'.$idGeneralSection;
		return $this->_rootElement->find($idGeneralSection);
	}

    /**
     * @param $idHeadOpen
     */
	public function openGeneralSection($idHeadOpen)
	{
        $idHeadOpen = '#'.$idHeadOpen;
        $this->_rootElement->find($idHeadOpen)->click();
	}

    /**
     * @param array $formFields
     * @return $this
     */
    public function fillNotFixture(array $formFields){
        $mapping = $this->dataMapping($formFields);
        $this->_fill($mapping);
        return $this;
    }

}