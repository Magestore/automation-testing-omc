<?php
/**
 * Created by: thomas
 * Date: 04/11/2017
 * Time: 00:16
 * Email:  thomas@trueplus.vn
 * Links : https://www.facebook.com/Onjin.Matsui.VTC.NQC
 */

namespace Magento\Webpos\Test\TestCase\Synchronization;

use Magento\Tax\Test\Fixture\TaxRate;
use Magento\Tax\Test\Page\Adminhtml\TaxRateIndex;
use Magento\Tax\Test\Page\Adminhtml\TaxRateNew;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Webpos\Test\Constraint\Synchronization\AssertItemUpdateSuccess;

/**
 * Test Flow:
 *
 * Preconditions:
 * 1. Create Tax Rate.
 *
 * Steps:
 * 1. Login to backend.
 * 2. Navigate to Stores -> Taxes -> Tax Zones and Rates.
 * 3. Search tax rate in grid by given data.
 * 4. Open this tax rate by clicking.
 * 5. Edit test value(s) according to dataset.
 * 6. Click 'Save Rate' button.
 * 7. Perform asserts.
 *
 * @group Tax_(CS)
 * @ZephyrId MAGETWO-23299
 */
class WebposSynchronizationReloadTaxRateEntityTest extends Injectable
{
    /* tags */
    const MVP = 'yes';
    const DOMAIN = 'CS';
    /* end tags */

    /**
     * Tax Rate grid page.
     *
     * @var TaxRateIndex
     */
    protected $taxRateIndex;

    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Tax Rate new/edit page.
     *
     * @var TaxRateNew
     */
    protected $taxRateNew;

    /**
     * @var AssertItemUpdateSuccess
     */
    protected $assertItemUpdateSuccess;

    /**
     * Injection data.
     *
     * @param TaxRateIndex $taxRateIndex
     * @param TaxRateNew $taxRateNew
     * @return void
     */
    public function __inject(
        TaxRateIndex $taxRateIndex,
        WebposIndex $webposIndex,
        TaxRateNew $taxRateNew,
        AssertItemUpdateSuccess $assertItemUpdateSuccess
    ) {
        $this->taxRateIndex = $taxRateIndex;
        $this->webposIndex = $webposIndex;
        $this->taxRateNew = $taxRateNew;
        $this->assertItemUpdateSuccess = $assertItemUpdateSuccess;
    }

    /**
     * Update Tax Rate Entity test.
     *
     * @param TaxRate $initialTaxRate
     * @param TaxRate $taxRate
     * @return void
     */
    public function testUpdateTaxRate(
        TaxRate $taxRate,
        $value,
        Staff $staff,
        $action
    ) {

        // Steps
        $filter = [
            'code' => $value,
        ];
        $this->taxRateIndex->open();
        sleep(1);
        $this->taxRateIndex->getTaxRateGrid()->searchAndOpen($filter);
        sleep(1);
        $this->taxRateNew->getTaxRateForm()->fill($taxRate);
        sleep(1);
        $this->taxRateNew->getFormPageActions()->save();
        sleep(3);

        $this->webposIndex->open();
        $this->webposIndex->getLoginForm()->fill($staff);
        $this->webposIndex->getLoginForm()->clickLoginButton();
        sleep(3);
        while ($this->webposIndex->getFirstScreen()->isVisible()) {}
        sleep(3);

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        sleep(2);
        $this->webposIndex->getCMenu()->synchronization();
        sleep(2);
        $itemText = 'Tax Rate';
        if ($action == 'reload') {
            $this->webposIndex->getSynchronization()->getItemRowReloadButton($itemText)->click();
        } else {
            $this->webposIndex->getSynchronization()->getItemRowUpdateButton($itemText)->click();
        }

        // Assert Country reload success
        $action = 'Reload';
        $this->assertItemUpdateSuccess->processAssert($this->webposIndex, $itemText, $action);
    }
}
