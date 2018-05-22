<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 26/02/2018
 * Time: 10:45
 */

namespace Magento\Webpos\Test\TestCase\Setting\CheckoutTab;

use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\CatalogRule\Test\Page\Adminhtml\CatalogRuleIndex;
use Magento\CatalogRule\Test\Page\Adminhtml\CatalogRuleNew;
use Magento\CatalogRule\Test\Fixture\CatalogRule;
use Magento\Mtf\Fixture\FixtureFactory;
/**
 * Class WebPOSAutoCheckThePromotionRulesOnCheckoutTest
 * @package Magento\Webpos\Test\TestCase\Setting\CheckoutTab
 */
class WebPOSAutoCheckThePromotionRulesOnCheckoutTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    /**
     * @var OrderIndex
     */
    protected $orderIndex;

    /**
     * @var CatalogRuleIndex
     */
    protected $catalogRuleIndex;

    /**
     * @var CatalogRuleNew
     */
    protected $catalogRuleNew;

    protected $menuItem;
    protected $optionNo;
    protected $successMessage;
    protected $catalogPriceRule;

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

    public function test(
        $menuItem,
        $optionYes,
        $optionNo,
        $successMessage,
        $products,
        CatalogRule $catalogPriceRule,
        FixtureFactory $fixtureFactory
    ) {
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
            $prices[$i] = explode("$",$this->webposIndex->getCheckoutCartItems()->getValueItemPrice($products[$i]->getName()));
            $originalPrices[$i] = explode("Reg. $", $this->webposIndex->getCheckoutCartItems()->getCartOriginalItemPrice($products[$i]->getName())->getText());
            $i++;
            sleep(2);
        }
        $this->webposIndex->getCheckoutCartFooter()->getButtonCheckout()->click();
        $this->webposIndex->getMsWebpos()->waitCartLoader();
        $this->webposIndex->getMsWebpos()->waitCheckoutLoader();
        //Assert that WebPOS Apply the catalog price rule successfully.
        $number = count($prices);
        for ($j=0;$j<$number;$j++) {
            $prices[$j] = (float)$prices[$j][0];
            $originalPrices[$j] = (float)$originalPrices[$j][1];
            self::assertEquals(
                $originalPrices[$j],
                2*$prices[$j],
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