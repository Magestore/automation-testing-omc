<?php
namespace Magento\Giftvoucher\Test\TestStep;

use Magento\Mtf\TestStep\TestStepInterface;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexIndex;
use Magento\Giftvoucher\Test\Page\GiftvoucherIndexAdd;
use Magento\Mtf\Fixture\FixtureFactory;
use Magento\Giftvoucher\Test\Fixture\Giftcode;

class PagingGiftcodeListStep implements TestStepInterface
{
    /**
     * Gift Card Index Page
     *
     * @var GiftvoucherIndexIndex
     */
    protected $giftvoucherIndexIndex;

    public function __construct(
        GiftvoucherIndexIndex $giftvoucherIndexIndex,
        GiftvoucherIndexAdd $giftvoucherIndexAdd,
        FixtureFactory $fixtureFactory,
        $giftcode = []
    ) {
        $this->giftvoucherIndexIndex = $giftvoucherIndexIndex;
        for ($i = $giftcode['count']; $i > 0; $i--) {
            /** @var Giftcode $item */
            $item = $fixtureFactory->createByCode($giftcode['fixtureType'], [
                'dataset' => $giftcode['dataset'],
            ]);
            $item->persist();
            $giftvoucherIndexAdd->open();
            $giftvoucherIndexAdd->getAddGiftcodeForm()->addGiftcode($item->getGiftCode());
            $giftvoucherIndexIndex->getAccountGiftcodesBlock()->waitPageInit();
        }
    }

    public function run()
    {
        $result = [];
        $this->giftvoucherIndexIndex->open();
        $block = $this->giftvoucherIndexIndex->getAccountGiftcodesBlock();
        $block->waitPageInit();
        $result[] = $block->getFirstItemId();
        // MA030: Next page
        $block->nextPage()->waitPageInit();
        $result[] = $block->getFirstItemId();
        // MA032: Previous Page
        $block->prevPage()->waitPageInit();
        $result[] = $block->getFirstItemId();
        // MA031: Go to Page
        $block->gotoPage(2)->waitPageInit();
        $result[] = $block->getFirstItemId();
        
        return ['result' => $result];
    }
}
