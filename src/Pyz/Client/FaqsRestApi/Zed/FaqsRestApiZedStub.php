<?php

namespace Pyz\Client\FaqsRestApi\Zed;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class FaqsRestApiZedStub implements FaqsRestApiZedStubInterface {

    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param FaqCollectionTransfer $faqCollectionTransfer
     * @return \Generated\Shared\Transfer\FaqCollectionTransfer
     */
    public function getFaqCollection(
        FaqCollectionTransfer $faqCollectionTransfer
    ): FaqCollectionTransfer
    {
        /** @var \Generated\Shared\Transfer\FaqCollectionTransfer $faqCollectionTransfer */

        $faqCollectionTransfer = $this->zedRequestClient->call(
            '/faq/gateway/get-faq-collection',
            $faqCollectionTransfer
        );

        return $faqCollectionTransfer;
    }

    public function getFaqEntity(FaqTransfer $trans): ?FaqTransfer {

        try {
            /** @var null|\Generated\Shared\Transfer\FaqTransfer $trans */

            $trans = $this->zedRequestClient->call(
                '/faq/gateway/get-faq-entity',
                $trans
            );
        }
        catch(\Exception $e) { // not found
            return null;
        }

        return $trans;
    }
}
