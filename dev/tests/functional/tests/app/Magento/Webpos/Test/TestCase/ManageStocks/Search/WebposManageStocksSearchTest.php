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

/**
 * Search
 * Testcase MSK06 - Search without result
 *
 * Precondition
 * 1. Login Webpos as a staff
 * 2. Go to Manage Stocks page
 *
 * Steps
 * 1. Enter incorrect name or sku into Search box
 * 2. Click on Search icon
 *
 * Acceptance Criteria
 * 2. The result is not found
 *
 * Class WebposManageStocksSearchTest
 * @package Magento\Webpos\Test\TestCase\ManageStocks\Search
 */
class WebposManageStocksSearchTest extends Injectable
{
    /**
     * @var WebposIndex
     */
    protected $webposIndex;

    public function __prepare(FixtureFactory $fixtureFactory)
    {
        $product = $fixtureFactory->createByCode('catalogProductSimple', ['dataset' => 'product_in_primary_warehouse']);
        $product = $this->objectManager->create('Magento\Catalog\Test\Handler\CatalogProductSimple\Curl')->persist($product);

        return ['product' => $product];
    }


    public function __inject(
        WebposIndex $webposIndex
    )
    {
        $this->webposIndex = $webposIndex;
    }

    public function test(
        $product,
        $action
    )
    {
        /*Get product by ID*/
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product_entity = $objectManager->create('Magento\Catalog\Model\Product')->load($product['id']);

        // LoginTest webpos
        $staff = $this->objectManager->getInstance()->create(
            'Magento\Webpos\Test\TestStep\LoginWebposStep'
        )->run();

        $this->webposIndex->getMsWebpos()->clickCMenuButton();
        $this->webposIndex->getCMenu()->manageStocks();

        $this->webposIndex->getManageStockList()->waitForProductListShow();
        $searchText = '';

        if ($action === 'search_incorrect') {
            $searchText = 'asajbabjadbvdakvb';
        } elseif ($action === 'search_name') {
            $searchText = $product_entity->getName();
        } elseif ($action === 'search_sku') {
            $searchText = $product_entity->getSku();
        } elseif ($action === 'clear_keyword') {
            $this->webposIndex->getManageStockList()->searchProduct('asajbabjadbvdakvb');
            $searchText = '';
        }
        $this->webposIndex->getManageStockList()->searchProduct($searchText);
        sleep(2);
    }
}