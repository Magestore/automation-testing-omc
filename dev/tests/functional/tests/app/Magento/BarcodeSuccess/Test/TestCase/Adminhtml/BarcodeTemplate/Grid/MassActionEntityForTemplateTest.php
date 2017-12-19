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
use Magento\BarcodeSuccess\Test\Fixture\Template;


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

    public function test(Template $template, $massAction, $option = null)
    {
        $this->massAction = $massAction;
        $this->nameTemplate = $template->getName();
        //persis
        $this->barcodeTemplateIndex->open();
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getAddNewTemplate()->addNewTemplate('new');
        $this->barcodeViewTemplateIndex->getBlockViewTemplate()->fill($template);
        $this->barcodeViewTemplateIndex->getPageActionsBlock()->save();
        //MassAction
        $this->barcodeTemplateIndex->getTemplateGrid()->searchAndSelect(['name' => $template->getName()]);
        $this->barcodeTemplateIndex->getTemplateGrid()->selectActionWithAlert($massAction, $option);
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
    }
    public function tearDown()
    {
        if($this->massAction!='Delete'){
            $this->barcodeTemplateIndex->open();
            $this->barcodeTemplateIndex->getTemplateGrid()->searchAndSelect(['name' => $this->nameTemplate]);
            $this->barcodeTemplateIndex->getTemplateGrid()->selectActionWithAlert('Delete');
            $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        }

    }
}