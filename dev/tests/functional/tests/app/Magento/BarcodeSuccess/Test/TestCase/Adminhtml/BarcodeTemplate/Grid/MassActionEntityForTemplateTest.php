<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 14/12/2017
 * Time: 14:22
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeTemplate\Grid;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeTemplateIndex;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeViewTemplateIndex;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Fixture\TemplateBarcode;
/**
 *
 * Test Flow:
 * Preconditions:
 * 1. Create template
 *
 * Steps:
 * 1. Open backend
 * 2. Go to  page BarcodeTemplate grid
 * 3. Select template from preconditions
 * 4. Select in MassAction ("Delete" or "Change status")
 * 5. Accept alert
 * 6. Perform all assertions according to dataset
 *
 */

class MassActionEntityForTemplateTest extends Injectable
{
    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * @var BarcodeTemplateIndex $barcodeTemplateIndex
     */

    protected $barcodeTemplateIndex;
    /**
     * @var BarcodeViewTemplateIndex $barcodeViewTemplateIndex
     */
    protected $barcodeViewTemplateIndex;

    protected $massAction;
    protected $nameTemplate;

    public function __inject(
        BarcodeTemplateIndex $barcodeTemplateIndex,
        BarcodeViewTemplateIndex $barcodeViewTemplateIndex
    ) {
        $this->barcodeTemplateIndex = $barcodeTemplateIndex;
        $this->barcodeViewTemplateIndex = $barcodeViewTemplateIndex;
    }

    public function test(TemplateBarcode $template, $massAction, $option = null)
    {
        $this->massAction = $massAction;
        $this->nameTemplate = $template->getName();
        $template->persist();
        //MassAction
        $this->barcodeTemplateIndex->open();
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getTemplateGrid()->searchAndSelect(['name' => $template->getName()]);
        $this->barcodeTemplateIndex->getTemplateGrid()->selectActionWithAlert($massAction, $option);
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getTemplateGrid()->resetFilter();

    }
    public function tearDown()
    {
        if($this->massAction!='Delete'){
            $this->barcodeTemplateIndex->open();
            $this->barcodeTemplateIndex->getTemplateGrid()->searchAndSelect(['name' => $this->nameTemplate]);
            $this->barcodeTemplateIndex->getTemplateGrid()->selectActionWithAlert('Delete');
            $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
            $this->barcodeTemplateIndex->getTemplateGrid()->resetFilter();
        }
        $this->barcodeTemplateIndex->getTemplateGrid()->resetFilter();

    }
}