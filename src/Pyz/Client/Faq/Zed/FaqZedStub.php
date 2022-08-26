<?php

namespace Pyz\Client\Faq\Zed;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class FaqZedStub implements FaqZedStubInterface {

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

    protected function boolRequest(FaqTransfer $trans, string $endpoint): bool {
        try {
            /** @var null|\Generated\Shared\Transfer\FaqTransfer $trans */

            $trans = $this->zedRequestClient->call(
                $endpoint,
                $trans
            );
        }
        catch(\Exception $e) { // not found
            return false;
        }

        return true;
    }

    public function createFaqEntity(FaqTransfer $trans): bool {
        return $this->boolRequest($trans, '/faq/gateway/create-faq-entity');
    }

    public function deleteFaqEntity(FaqTransfer $trans): bool {
        return $this->boolRequest($trans, '/faq/gateway/delete-faq-entity');
    }

    public function updateFaqEntity(FaqTransfer $trans): bool {
        return $this->boolRequest($trans, '/faq/gateway/update-faq-entity');
    }
}
