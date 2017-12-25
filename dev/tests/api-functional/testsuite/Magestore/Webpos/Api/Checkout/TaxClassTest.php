<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/12/2017
 * Time: 14:06
 */

namespace Magestore\Webpos\Api\Checkout;


use Magento\TestFramework\TestCase\WebapiAbstract;

class TaxClassTest extends WebapiAbstract
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
				'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_GET,
			],
		];


		$result = $this->_webApiCall($serviceInfo, $searchCriteria);
		$this->assertNotNull($result);
		self::assertGreaterThanOrEqual(
			1,
			$result['total_count'],
			"Result doesn't have any item (total_count < 1)"
		);
		$keys = ['class_id', 'class_name', 'class_type'];
		foreach ($keys as $key) {
			self::assertContains(
				$key,
				array_keys($result['items'][0]),
				$key . " key is not in found in result['items'][0]'s keys"
			);
		}
	}
}