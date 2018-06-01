<?php
/**
 * Created by PhpStorm.
 * User: PhucDo
 * Date: 2/23/2018
 * Time: 9:05 AM
 */

namespace Magento\Webpos\Test\TestCase\ProductsGrid\Search;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebposProductsGridPG50Test
 * @package Magento\Webpos\Test\TestCase\ProductsGrid\Search
 *
 * Precondition:
 * 1. Login Webpos as a staff
 *
 * Steps:
 * "1. Enter incorrect keyword on Search box
 * 2. Enter or click on Search icon"
 *
 * Acceptance:
 * 2. No results in list and show notice: "We couldn't find any records."
 *
 */
class WebposProductsGridPG50Test extends Injectable
{

    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @param WebposIndex $webposIndex
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * @param $key
     */
    public function test(
        $key
    )
    {
        // LoginTest webpos
        $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\SessionInstallStep'
        )->run();


        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutProductList()->search($key);
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
    }
}