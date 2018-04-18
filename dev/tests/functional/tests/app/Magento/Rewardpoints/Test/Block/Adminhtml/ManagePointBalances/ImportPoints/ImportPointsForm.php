<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 1:10 PM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml\ManagePointBalances\ImportPoints;

use Magento\Mtf\Block\Form;
use Magento\Mtf\Client\Locator;

/**
 * Class ImportPointsForm
 * @package Magento\Rewardpoints\Test\Block\Adminhtml\ManagePointBalances\ImportPoints
 */
class ImportPointsForm extends Form
{
    /**
     * @var string
     */
    protected $importPointsTitle = './/span[text()="Import Form"]';

    /**
     * @var string
     */
    protected $importFileField = '[data-ui-id="import-form-container-form-fieldset-element-file-filecsv"]';

    /**
     * @return mixed
     */
    public function importPointsTitleIsVisible()
    {
        return $this->_rootElement->find($this->importPointsTitle, Locator::SELECTOR_XPATH)->isVisible();
    }

    /**
     * @return mixed
     */
    public function importFileFieldIsVisible()
    {
        return $this->_rootElement->find($this->importFileField, Locator::SELECTOR_CSS)->isVisible();
    }
}