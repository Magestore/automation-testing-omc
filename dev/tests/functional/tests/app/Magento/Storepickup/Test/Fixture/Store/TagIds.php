<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 12/8/2017
 * Time: 9:36 PM
 */

namespace Magento\Storepickup\Test\Fixture\Store;

use Magento\Mtf\Fixture\DataSource;
use Magento\Mtf\Fixture\FixtureFactory;

class TagIds extends DataSource
{
    protected $tags = [];

    public function __construct(
        FixtureFactory $fixtureFactory,
        array $params,
        array $data = []
    ) {
        $this->params = $params;
        if (isset($data['dataset']) && $data['dataset'] !== '-') {
            $datasets = explode(',', $data['dataset']);
            foreach ($datasets as $dataset) {
                $tag = $fixtureFactory->createByCode('storepickupTag', ['dataset' => trim($dataset)]);
                if (!$tag->hasData('tag_id')) {
                    $tag->persist();
                }
                $this->tags[] = $tag;
                $this->data[] = [
                    'name' => $tag->getTagName()
                ];
            }
        }
    }

    /**
     * Return related products.
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }
}