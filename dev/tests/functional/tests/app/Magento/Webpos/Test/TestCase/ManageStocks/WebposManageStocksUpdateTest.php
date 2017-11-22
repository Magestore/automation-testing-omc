<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 22/09/2017
 * Time: 08:05
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks;


use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Fixture\Staff;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksUpdateTest extends Injectable
{
	protected $webposIndex;

	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(Staff $staff, $products)
	{
		$count = count($products);

		$this->webposIndex->open();
		if ($this->webposIndex->getLoginForm()->isVisible()) {
                $this->webposIndex->getLoginForm()->fill($staff);
                $this->webposIndex->getLoginForm()->clickLoginButton();
			sleep(5);
			while ($this->webposIndex->getFirstScreen()->isVisible()) {
			}
			sleep(2);
		}

            $this->webposIndex->getMsWebpos()->clickCMenuButton();
            $this->webposIndex->getCMenu()->manageStocks();

		self::assertNotFalse(
			$this->webposIndex->getManageStocks()->isVisible(),
			'MS01 Manage Stocks page is not visibled'
		);
		$num = 0;
		foreach ($products as $item) {
			$num++;
			self::assertNotFalse(
				$this->webposIndex->getManageStocks()->getProduct($num)->isVisible(),
				"product list don't have product"
            );


			$this->webposIndex->getManageStocks()->getQtyInput($num)->setValue($item['qty']);
			$inStockCheckbox = $this->webposIndex->getManageStocks()->getInStockCheckbox($num);
			if ($item['isInStock'] != $this->webposIndex->getManageStocks()->isCheckboxChecked($inStockCheckbox)) {
				$inStockCheckbox->click();
			}

			$products[$num-1]['sku'] = $this->webposIndex->getManageStocks()->getProductSKU($num);
//			$item['qty'] = $item['qty'];
//			$item['isInStock'] = $item['isInStock'];

			self::assertNotFalse(
				$this->webposIndex->getManageStocks()->getUpdateButton($num)->isVisible(),
				'MS05 - update button is not showed'
			);
			if ($count == 1) {
				$this->webposIndex->getManageStocks()->getUpdateButton($num)->click();
				sleep(2);
//				self::assertFalse(
//					$this->webposIndex->getManageStocks()->getUpdateButton($num)->isVisible(),
//					'MS06 - update button is not hided'
//				);
//				self::assertNotFalse(
//					$this->webposIndex->getManageStocks()->getUpdateSuccessIcon($num)->isVisible(),
//					'MS06 - update success icon is not showed'
//				);
			}
		}
		if ($count > 1) $this->webposIndex->getManageStocks()->getUpdateAllButton()->click();
		sleep(2);
		return ['products' => $products];
	}
}
