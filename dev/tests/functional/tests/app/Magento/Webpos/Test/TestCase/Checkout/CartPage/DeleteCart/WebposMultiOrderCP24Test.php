<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 06/12/2017
 * Time: 15:01
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CartPage\DeleteCart;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposMultiOrderCP24Test extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        CatalogProductSimple $product, $number
    )
    {
        // Login webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();

        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getCheckoutCartHeader()->getAddMultiOrder()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getCheckoutWebposCart()->getIconRemoveMultiOrder($number)->click();
    }
}