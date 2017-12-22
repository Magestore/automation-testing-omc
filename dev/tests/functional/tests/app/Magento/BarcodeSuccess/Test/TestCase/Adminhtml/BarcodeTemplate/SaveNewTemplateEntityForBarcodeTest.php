<?php
/**
 * Created by PhpStorm.
 * User: gvt
 * Date: 05/12/2017
 * Time: 10:10
 */
namespace Magento\BarcodeSuccess\Test\TestCase\Adminhtml\BarcodeTemplate;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeTemplateIndex;
use Magento\BarcodeSuccess\Test\Page\Adminhtml\BarcodeTemplate\BarcodeViewTemplateIndex;
use Magento\Mtf\TestCase\Injectable;
use Magento\BarcodeSuccess\Test\Fixture\Template;


class SaveNewTemplateEntityForBarcodeTest extends Injectable
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

    /**
     * @var Template
     */
    protected $template;

    public function __inject(
        BarcodeTemplateIndex $barcodeTemplateIndex,
        BarcodeViewTemplateIndex $barcodeViewTemplateIndex
    ) {
        $this->barcodeTemplateIndex = $barcodeTemplateIndex;
        $this->barcodeViewTemplateIndex = $barcodeViewTemplateIndex;
    }

    public function test($addNewButton,Template $template)
    {
        $this->barcodeTemplateIndex->open();
        $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        $this->barcodeTemplateIndex->getAddNewTemplate()->addNewTemplate($addNewButton);
        $this->barcodeViewTemplateIndex->getBlockViewTemplate()->fill($template);
        $this->barcodeViewTemplateIndex->getPageActionsBlock()->save();
        $this->template = $template;
    }

    public function tearDown()
    {
        if($this->template->getName()!=''){
            $this->barcodeTemplateIndex->open();
            $this->barcodeTemplateIndex->getTemplateGrid()->searchAndSelect(['name' => $this->template->getName()]);
            $this->barcodeTemplateIndex->getTemplateGrid()->selectActionWithAlert('Delete');
            $this->barcodeTemplateIndex->getTemplateGrid()->waitingForLoadingMaskNotVisible();
        }

    }

}