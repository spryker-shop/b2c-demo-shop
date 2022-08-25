<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Creator;

use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Pyz\Client\FaqsRestApi\FaqsRestApiClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class FaqsCreator implements FaqsCreatorInterface {

    protected FaqsRestApiClientInterface $faqsRestApiClient;
    protected RestResourceBuilderInterface $restResourceBuilder;

    public function __construct(
        FaqsRestApiClientInterface $faqsRestApiClient,
        RestResourceBuilderInterface   $restResourceBuilder
    ){

        $this->faqsRestApiClient = $faqsRestApiClient;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    public function createFaqEntity(RestRequestInterface $restRequest, FaqTransfer $trans): RestResponseInterface {
        $response = $this->restResourceBuilder->createRestResponse();

        $res = $this->faqsRestApiClient
            ->createFaqEntity($trans);

        if($res) {
            return $response->addError(
                (new RestErrorMessageTransfer())
                    ->setCode('Created successfully')
                    ->setStatus(201)
            );
        }

        return $response->addError(
            (new RestErrorMessageTransfer())
                ->setCode('An error occurred while creating')
                ->setStatus(500)
        );
    }
}
