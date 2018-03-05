<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 02/03/2018
 * Time: 10:54
 */

namespace Magento\Webpos\Test\TestCase\ManageStocks\Search;


use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Mtf\TestCase\Injectable;
use Magento\Webpos\Test\Page\WebposIndex;

class WebposManageStocksSearchTest extends Injectable
{
	/**
	 * @var WebposIndex
	 */
	protected $webposIndex;

	public function __prepare(FixtureFactory $fixtureFactory)
	{
		$product = $fixtureFactory->createByCode('catalogProductSimple');
		$product->persist();
		return ['product' => $product];
	}


	public function __inject(
		WebposIndex $webposIndex
	)
	{
		$this->webposIndex = $webposIndex;
	}

	public function test(
		CatalogProductSimple $product,
		$action
	)
	{
		// Login webpos
		$staff = $this->objectManager->getInstance()->create(
			'Magento\Webpos\Test\TestStep\LoginWebposStep'
		)->run();

		$this->webposIndex->getMsWebpos()->clickCMenuButton();
		$this->webposIndex->getCMenu()->manageStocks();
		sleep(2);

		$searchText = '';

		if ($action === 'search_incorrect') {
			$searchText = 'asajbabjadbvdakvb';
		}
		elseif ($action === 'search_name') {
			$searchText = $product->getName();
		}
		elseif ($action === 'search_sku') {
			$searchText = $product->getSku();
		}
		elseif ($action === 'clear_keyword') {
			$this->webposIndex->getManageStockList()->searchProduct('asajbabjadbvdakvb');
			$searchText = '';
		}

		$this->webposIndex->getManageStockList()->searchProduct($searchText);
	}
}