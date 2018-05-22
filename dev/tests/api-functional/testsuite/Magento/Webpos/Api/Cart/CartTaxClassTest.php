<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/12/2017
 * Time: 14:06
 */

namespace Magento\Webpos\Api\Cart;

use Magento\TestFramework\TestCase\WebapiAbstract;
use \Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class CartTaxClassTest
 * @package Magento\Webpos\Api\Cart
 */
class CartTaxClassTest extends WebapiAbstract
{
	const RESOURCE_PATH = '/V1/webpos/taxclass/list';

	/**
	 * Api Name: Get Tax Class
	 */
	public function testGetList()
	{
		$searchCriteria = [
			'searchCriteria' => [
				'current_page' => 1,
				'page_size' => 200,
			],
		];

		$serviceInfo = [
			'rest' => [
				'resourcePath' => self::RESOURCE_PATH . '?' . http_build_query($searchCriteria),
				'httpMethod' => RestRequest::HTTP_METHOD_GET,
			],
		];

		$results = $this->_webApiCall($serviceInfo, $searchCriteria);

        // Dump the result to check "How does it look like?"
        // \Zend_Debug::dump($results);

        $this->assertNotNull($results);
		self::assertGreaterThanOrEqual(
			1,
			$results['total_count'],
			"Result doesn't have any item (total_count < 1)"
		);
		$keys = ['class_id', 'class_name', 'class_type'];
		foreach ($keys as $key) {
			self::assertContains(
				$key,
				array_keys($results['items'][0]),
				$key . " key is not in found in result['items'][0]'s keys"
			);
		}
	}
}