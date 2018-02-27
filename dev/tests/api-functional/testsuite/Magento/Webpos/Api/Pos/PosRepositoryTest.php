<?php
/**
 * Created by PhpStorm.
 * User: vinh
 * Date: 25/12/2017
 * Time: 14:31
 */

namespace Magento\Webpos\Api\Pos;

use Magento\TestFramework\Helper\Bootstrap;
use Magento\TestFramework\TestCase\WebapiAbstract;
use Magento\Framework\Webapi\Rest\Request as RestRequest;
/**
 * Class PosRepositoryTest
 * @package Magento\Webpos\Api\Pos
 */
class PosRepositoryTest extends WebapiAbstract
{
	const POS_LIST_RESOURCE_PATH = '/V1/webpos/poslist';
	const ASSIGN_STAFF_RESOURCE_PATH = '/V1/webpos/posassign';

    /**
     * @var \Magento\Webpos\Api\CurrentSessionId\CurrentSessionIdTest
     */
    protected $currentSession;

    /**
     * @var \Magento\Webpos\Api\Pos\Constraint\PosRepository
     */
    protected $posRepository;

    protected function setUp()
    {
        $this->currentSession = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\CurrentSessionId\CurrentSessionIdTest');
        $this->posRepository = Bootstrap::getObjectManager()->get('\Magento\Webpos\Api\Pos\Constraint\PosRepository');
    }

	/**
	 * Api Name: Get list POS
	 *
	 * @magentoApiDataFixture Magento/Webpos/_file/denomination.php
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
				'httpMethod' => RestRequest::HTTP_METHOD_GET,
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
        // Get the key constraint for API Get list POS. Call From Folder Constraint
		$keys = $this->posRepository->GetList();

        $key1 = $keys['key1'];
		foreach ($key1 as $key) {
			self::assertContains(
				$key,
				array_keys($result['items'][0]),
				$key . " key is not in found in result['items'][0]'s keys"
			);
		}

        $denominationKeys = $keys['denominationKey'];
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
				'httpMethod' => RestRequest::HTTP_METHOD_POST,
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