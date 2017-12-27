<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/12/2017
 * Time: 14:31
 */

namespace Magestore\Webpos\Api\Pos;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;

/**
 * Class PosRepositoryTest
 * @package Magestore\Webpos\Api\Pos
 */
class PosRepositoryTest extends WebapiAbstract
{
	const POS_LIST_RESOURCE_PATH = '/V1/webpos/poslist';
	const ASSIGN_STAFF_RESOURCE_PATH = '/V1/webpos/posassign';

    /**
     * @var \Magestore\Webpos\Api\CurrentSessionId\CurrentSessionIdTest
     */
    protected $currentSession;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magestore\Webpos\Api\CurrentSessionId\CurrentSessionIdTest');
    }

	/**
	 * Api Name: Get list POS
	 *
	 * @magentoApiDataFixture Magestore/Webpos/_file/denomination.php
	 */
	public function testGetList()
	{
		$searchCriteria = [
			'searchCriteria' => [
				'filter_groups' => [
					[
						'filters' => [
							[
								'field' => 'staff_id',
								'value' => '1',
								'condition_type' => 'eq',
							],
						],
					],
				],
				'sortOrders' => [
					[
						'field' => 'pos_name',
						'direction' => 'ASC'
					],
				],
			]
		];

		$serviceInfo = [
			'rest' => [
				'resourcePath' => self::POS_LIST_RESOURCE_PATH . '?' . http_build_query($searchCriteria),
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
		self::assertEquals(
			1,
			$result['items'][0]['staff_id'],
			'staff_id is wrong'
		);
		$keys = [
			'pos_name',
			'location_id',
			'staff_id',
			'store_id',
			'status',
			'denomination_ids',
			'denominations'
		];
		$denominationKeys = [
			'denomination_id',
			'denomination_name',
			'denomination_value',
			'pos_ids',
			'sort_order'
		];
		foreach ($keys as $key) {
			self::assertContains(
				$key,
				array_keys($result['items'][0]),
				$key . " key is not in found in result['items'][0]'s keys"
			);
		}

		foreach ($denominationKeys as $denominationKey) {
			self::assertContains(
				$denominationKey,
				array_keys($result['items'][0]['denominations']),
                $denominationKey . " key is not in found in result['items'][0]['denominations']'s keys"
			);
		}
	}

	/**
	 * Api Name: POS Assign
	 */
	public function testAssignStaff()
	{
		$serviceInfo = [
			'rest' => [
				'resourcePath' => self::ASSIGN_STAFF_RESOURCE_PATH,
				'httpMethod' => \Magento\Framework\Webapi\Rest\Request::HTTP_METHOD_POST,
			],
		];

		$requestData = [
			"location_id" => 1,
            "current_session_id" => $this->currentSession->getCurrentSessionId(),
            "pos_id" => "1"
		];

		$result = $this->_webApiCall($serviceInfo, $requestData);
		self::assertTrue(
			$result,
			'result is not TRUE'
		);
	}
}