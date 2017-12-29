<?php
/**
 * Created by PhpStorm.
 * User: vong
 * Date: 12/28/2017
 * Time: 11:19 PM
 */

namespace Magento\PurchaseOrderSuccess\Test\Block\Adminhtml\Supplier\Filter;

use Magento\Mtf\Client\Browser;
use Magento\Mtf\Client\DriverInterface;
use Magento\Mtf\Client\Element\DropdownmultiselectElement;
use Magento\Mtf\Client\ElementInterface;
use Magento\Mtf\Client\Locator;
use Magento\Mtf\System\Event\EventManagerInterface;

class Status extends DropdownmultiselectElement
{
    protected $browser;

    public function __construct(
        DriverInterface $driver,
        EventManagerInterface $eventManager,
        Locator $locator,
        ElementInterface $context = null,
        Browser $browser
    ) {
        $this->browser = $browser;
        parent::__construct($driver, $eventManager, $locator, $context);
    }

    public function setValue($values)
    {
        $this->eventManager->dispatchEvent(['set_value'], [__METHOD__, $this->getAbsoluteSelector()]);
        $this->find($this->toggle)->click();
        $values = is_array($values) ? $values : [$values];
        foreach ($values as $value) {
            $this->browser->find(
                sprintf($this->optionByValue, $this->escapeQuotes($value)),
                Locator::SELECTOR_XPATH
            )->click();
        }
//        $this->find($this->toggle)->click();
    }
}