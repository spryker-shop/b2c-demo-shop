<?php

namespace Pyz\Client\FaqsRestApi;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\FaqsRestApi\FaqsRestApiFactory getFactory()
 */
class FaqsRestApiClient
    extends AbstractClient
    implements FaqsRestApiClientInterface {


    /**
     * @api
     * @return \Generated\Shared\Transfer\FaqCollectionTransfer
     */
    public function getFaqCollection(FaqCollectionTransfer $faqCollectionTransfer): FaqCollectionTransfer
    {
        return $this->getFactory()
            ->createFaqZedStub()
            ->getFaqCollection($faqCollectionTransfer);
    }

    public function getFaqEntity(FaqTransfer $trans): ?FaqTransfer {

        return $this->getFactory()
            ->createFaqZedStub()
            ->getFaqEntity($trans);
    }

}
