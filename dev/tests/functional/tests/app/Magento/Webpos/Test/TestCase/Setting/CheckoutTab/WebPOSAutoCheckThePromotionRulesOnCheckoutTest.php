<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/02/2018
 * Time: 10:45
 */

namespace Magento\Webpos\Test\TestCase\Setting\CheckoutTab;

use Magento\CatalogRule\Test\Fixture\CatalogRule;
use Magento\CatalogRule\Test\Page\Adminhtml\CatalogRuleIndex;
use Magento\CatalogRule\Test\Page\Adminhtml\CatalogRuleNew;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Webpos\Test\Page\WebposIndex;

/**
 * Class WebPOSAutoCheckThePromotionRulesOnCheckoutTest
 * @package Magento\Webpos\Test\TestCase\Setting\CheckoutTab
 * Precondition and setup steps
 * Precondition: Exist an active catalog price rule on backend
 * 1. Login webpos as a staff
 * 2. Click on [General] menu > [Checkout] tab
 * 3. [Auto check the promotion rules on checkout] = Yes
 *
 * Steps
 * 1. Add some products that meet catalog price rule to cart
 * 2. Click on [Checkout]
 *
 * Acceptance Criteria
 * 2. Promotion will be checked and updated to cart automatically
 */
class WebPOSAutoCheckThePromotionRulesOnCheckoutTest extends Injectable
{
    /**
     * @var WebposIndex $webposIndex
     */
    protected $webposIndex;

    /**
     * @var OrderIndex $orderIndex
     */
    protected $orderIndex;

    /**
     * @var CatalogRuleIndex $catalogRuleIndex
     */
    protected $catalogRuleIndex;

    /**
     * @var CatalogRuleNew $catalogRuleNew
     */
    protected $catalogRuleNew;

    protected $menuItem;
    protected $optionNo;
    protected $successMessage;
    protected $catalogPriceRule;

    /**
     * @param WebposIndex $webposIndex
     * @param OrderIndex $orderIndex
     * @param CatalogRuleIndex $catalogRuleIndex
     * @param CatalogRuleNew $catalogRuleNew
     */
    public function __inject(
        WebposIndex $webposIndex,
        OrderIndex $orderIndex,
        CatalogRuleIndex $catalogRuleIndex,
        CatalogRuleNew $catalogRuleNew
    )
    {
        $this->webposIndex = $webposIndex;
        $this->orderIndex = $orderIndex;
        $this->catalogRuleIndex = $catalogRuleIndex;
        $this->catalogRuleNew = $catalogRuleNew;
    }

    /**
     * @param $menuItem
     * @param $optionYes
     * @param $optionNo
     * @param $successMessage
     * @param $products
     * @param CatalogRule $catalogPriceRule
     * @param FixtureFactory $fixtureFactory
     */
    public function test(
        $menuItem,
        $optionYes,
        $optionNo,
        $successMessage,
        $products,
        CatalogRule $catalogPriceRule,
        FixtureFactory $fixtureFactory
    )
    {
        //set Value for tearDown function
        $this->menuItem = $menuItem;
        $this->optionNo = $optionNo;
        $this->successMessage = $successMessage;

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->general();
        sleep(1);
        $this->webposIndex->getGeneralSettingMenuLMainItem()->getMenuItem($menuItem)->click();
        sleep(1);
        $this->webposIndex->getGeneralSettingContentRight()->selectAutoCheckPromotionOption($optionYes)->click();
        sleep(1);
        //Create New catalog price rule to cart
        $this->catalogRuleIndex->open();
        $this->catalogRuleIndex->getGridPageActions()->addNew();
        $this->catalogRuleNew->getEditForm()->fill($catalogPriceRule);
        $this->catalogRuleNew->getFormPageActions()->saveAndApply();

        //Return to checkout Page
        $this->webposIndex->open();
        $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        sleep(1);
        $i = 0;
        $prices = [];
        $originalPrices = [];
        foreach ($products as $product) {
            $products[$i] = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => $product]);
            $this->webposIndex->getCheckoutProductList()->search($products[$i]->getSku());
            $this->webposIndex->getCheckoutProductList()->waitProductListToLoad();
            $this->webposIndex->getMsWebpos()->waitCartLoader();
            $prices[$i] = explode("$", $this->webposIndex->getCheckoutCartItems()->getValueItemPrice($products[$i]->getName()));
            $originalPrices[$i] = explode("Reg. $", $this->webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($products[$i]->getName())->getText());
            $i++;
            sleep(2);
        }
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Assert that WebPOS Apply the catalog price rule successfully.
        $number = count($prices);
        for ($j = 0; $j < $number; $j++) {
            $prices[$j] = (float)$prices[$j][0];
            $originalPrices[$j] = (float)$originalPrices[$j][1];
            self::assertEquals(
                $originalPrices[$j],
                2 * $prices[$j],
                'abc'
            );
        }
        $this->catalogPriceRule = $catalogPriceRule->getName();
    }

    public function tearDown()
    {
        $filter = [
            'name' => $this->catalogPriceRule,
        ];

        $this->catalogRuleIndex->open();
        $this->catalogRuleIndex->getCatalogRuleGrid()->searchAndOpen($filter);
        $this->catalogRuleNew->getFormPageActions()->delete();
        $this->catalogRuleNew->getModalBlock()->acceptAlert();
    }
}