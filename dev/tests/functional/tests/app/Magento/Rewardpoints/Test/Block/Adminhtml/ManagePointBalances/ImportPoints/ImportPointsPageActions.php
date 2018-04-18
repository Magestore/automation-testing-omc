<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/27/2017
 * Time: 12:21 PM
 */

namespace Magento\Rewardpoints\Test\Block\Adminhtml\ManagePointBalances\ImportPoints;


use Magento\Backend\Test\Block\FormPageActions;
use Magento\Mtf\Client\Locator;

/**
 * Class ImportPointsPageActions
 * @package Magento\Rewardpoints\Test\Block\Adminhtml\ManagePointBalances\ImportPoints
 */
class ImportPointsPageActions extends FormPageActions
{
    /**
     * @var string
     */
    protected $actionButton = './/button[@title="%s"]';

    /**
     * @param $button
     * @return mixed
     */
    public function actionButtonIsVisible($button)
    {
        return $this->_rootElement->find(sprintf($this->actionButton, $button), Locator::SELECTOR_XPATH)->isVisible();
    }
}
