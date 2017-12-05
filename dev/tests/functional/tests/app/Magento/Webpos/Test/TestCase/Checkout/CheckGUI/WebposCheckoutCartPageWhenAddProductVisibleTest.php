<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/12/2017
 * Time: 11:40
 */

namespace Magento\Webpos\Test\TestCase\Checkout\CheckGUI;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;
/**
 * Class WebposCheckoutCartPageWhenAddProductVisibleTest
 * @package Magento\Webpos\Test\TestCase\Checkout\CheckGUI
 */
class WebposCheckoutCartPageWhenAddProductVisibleTest extends Injectable
{
    /**
     * Webpos Index page.
     *
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * Inject Webpos Login pages.
     *
     * @param WebposIndex $webposIndex
     * @return void
     */
    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    /**
     * Login Webpos group test.
     *
     * @param Staff $staff
     * @return void
     */
    public function test(Staff $staff, $products, $labels, $defaultValue)
    {
        $this->webposIndex->open();
        if ($this->webposIndex->getLoginForm()->isVisible()) {
            $this->webposIndex->getLoginForm()->fill($staff);
            $this->webposIndex->getLoginForm()->clickLoginButton();
            sleep(5);
            while ($this->webposIndex->getFirstScreen()->isVisible()) {
            }
            sleep(2);
        }
        $labels = explode(',', $labels);
        foreach ($labels as $label) {
            \PHPUnit_Framework_Assert::assertEquals(
                $defaultValue,
                str_replace('$', '', $this->webposIndex->getCheckoutCartFooter()->getGrandTotalItemPrice($label)->getText()),
                'On the Frontend Page - The Default ' .$label. ' at the Webpos Cart was not equal to zero.'
            );
        }
        foreach ($products as $product) {
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getCheckoutProductList()->search($product);
        }
    }
}
