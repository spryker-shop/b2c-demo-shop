<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Deleter;

use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\ReservationRequestTransfer;
use Generated\Shared\Transfer\ReservationResponseTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Pyz\Client\FaqsRestApi\FaqClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class FaqsDeleter implements FaqsDeleterInterface {


    protected FaqClientInterface $faqsRestApiClient;
    protected RestResourceBuilderInterface $restResourceBuilder;

    public function __construct(
        FaqClientInterface $faqsRestApiClient,
        RestResourceBuilderInterface   $restResourceBuilder
    ){

        $this->faqsRestApiClient = $faqsRestApiClient;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    public function deleteFaqEntity(RestRequestInterface $restRequest, FaqTransfer $trans): RestResponseInterface {

        $response = $this->restResourceBuilder->createRestResponse();

        $res = $this->faqsRestApiClient
            ->deleteFaqEntity($trans);

        if($res) {
            return $response->addError(
                (new RestErrorMessageTransfer())
                ->setCode('Deleted successfully')
                ->setStatus(201)
            );
        }

        return $response->addError(
            (new RestErrorMessageTransfer())
                ->setCode('An error occurred while deleting')
                ->setStatus(500)
        );
    }
}
