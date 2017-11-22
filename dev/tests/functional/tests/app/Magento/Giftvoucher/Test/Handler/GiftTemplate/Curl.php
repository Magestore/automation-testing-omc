<?php
/**
 * Copyright © 2017 Magestore. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Giftvoucher\Test\Handler\GiftTemplate;

use Magento\Backend\Test\Handler\Conditions;
use Magento\Mtf\Fixture\FixtureInterface;
use Magento\Mtf\Config\DataInterface;
use Magento\Mtf\System\Event\EventManagerInterface;
use Magento\Mtf\Util\Protocol\CurlTransport;
use Magento\Mtf\Util\Protocol\CurlTransport\BackendDecorator;

/**
 * Giftcode Curl
 */
class Curl extends Conditions implements GiftTemplateInterface
{
    /**
     * Post request for creating a giftcode
     *
     * @param FixtureInterface $fixture
     * @return array
     * @throws \Exception
     */
    public function persist(FixtureInterface $fixture = null)
    {
        // @TODO: Add Gift Template Data by new URL
        return [
            'giftcard_template_id' => 2,
            'template_name' => 'Default',
            'status' => 'Enable',
            'updated_at' => '05/05/2017',
        ];
    }
}
