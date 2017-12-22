<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 11/12/2017
 * Time: 23:05
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeTemplate\Grid;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeTemplateIndex;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Fixture\Template;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeViewTemplateIndex;

class FilterGridEntityForTemplateTest extends Injectable
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

    protected $nameTemplate;

    public function __inject(
        BarcodeTemplateIndex $barcodeTemplateIndex,
        BarcodeViewTemplateIndex $barcodeViewTemplateIndex
    ) {
        $this->barcodeTemplateIndex = $barcodeTemplateIndex;
        $this->barcodeViewTemplateIndex = $barcodeViewTemplateIndex;
    }

    public function test(Template $template)
    {
        $this->nameTemplate = $template->getName();
        //persis
        $this->barcodeTemplateIndex->open();
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getAddNewTemplate()->addNewTemplate('new');
        $this->barcodeViewTemplateIndex->getBlockViewTemplate()->fill($template);
        $this->barcodeViewTemplateIndex->getPageActionsBlock()->save();
        //MassAction
        $this->barcodeTemplateIndex->getTemplateGrid()->search(['name' => $template->getName()]);
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $idsInGrid = $this->barcodeTemplateIndex->getTemplateGrid()->getAllIds();

        sleep(5);
    }
    public function tearDown()
    {
        $this->barcodeTemplateIndex->open();
        $this->barcodeTemplateIndex->getTemplateGrid()->searchAndSelect(['name' => $this->nameTemplate]);
        $this->barcodeTemplateIndex->getTemplateGrid()->selectActionWithAlert('Delete');
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
    }
}