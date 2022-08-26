<?php

namespace Pyz\Client\Faq\Zed;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class FaqZedStub implements FaqZedStubInterface {

    protected ZedRequestClientInterface $zedRequestClient;

    public function __construct(ZedRequestClientInterface $zedRequestClient) {
        $this->zedRequestClient = $zedRequestClient;
    }

    public function getAllFaqs(PaginationTransfer $trans): FaqCollectionTransfer {

        /** @var \Generated\Shared\Transfer\FaqCollectionTransfer $faqCollectionTransfer */

        $faqCollectionTransfer = $this->zedRequestClient->call(
            '/faq/gateway/get-faq-collection-paginated',
            $trans
        );

        return $faqCollectionTransfer;

    }
}
