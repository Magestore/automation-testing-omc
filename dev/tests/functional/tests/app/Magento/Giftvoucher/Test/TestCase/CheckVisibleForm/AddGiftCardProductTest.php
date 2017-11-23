<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 22/11/2017
 * Time: 17:03
 */

namespace Magento\Giftvoucher\Test\TestCase;

use Magento\Giftvoucher\Test\Page\Adminhtml\GiftvoucherProductIndex;
use Magento\Mtf\TestCase\Injectable;
use Magento\Backend\Test\Page\Adminhtml\Dashboard;

/**
 * Class AddGiftCardProductTest
 * @package Magento\Giftvoucher\Test\TestCase
 */
class AddGiftCardProductTest extends Injectable
{
    const ERROR_TEXT = '404 Error';

    /**
     * Product page with a grid
     *
     * @var GiftvoucherProductIndex
     */
    protected $productGrid;

    /* tags */
    const MVP = 'no';
    const DOMAIN = 'PS';
    /* end tags */

    /**
     * Run menu navigation test.
     *
     * Injection data
     *
     * @param GiftvoucherProductIndex $productGrid
     * @return void
     */
    public function __inject
    (
        GiftvoucherProductIndex $productGrid
    )
    {
        $this->productGrid = $productGrid;
    }

    /**
     * Run create product virtual entity test
     *
     * @return void
     */
    public function test(Dashboard $dashboard, $menuItem, $pageTitle, $pageTitleForm)
    {
        // Steps
        $dashboard->open();
        $dashboard->getMenuBlock()->navigate($menuItem);
        self::assertEquals(
            $pageTitle,
            $dashboard->getTitleBlock()->getTitle(),
            'Invalid page title is displayed.'
        );
        self::assertNotContains(
            self::ERROR_TEXT,
            $dashboard->getErrorBlock()->getContent(),
            "404 Error is displayed on '$pageTitle' page."
        );
        sleep(2);
        $this->productGrid->getGridPageActionBlock()->getAddGiftCardProduct()->click();
        self::assertEquals(
            $pageTitleForm,
            $dashboard->getTitleBlock()->getTitle(),
            'Invalid page title is displayed.'
        );
        sleep(2);
    }
}