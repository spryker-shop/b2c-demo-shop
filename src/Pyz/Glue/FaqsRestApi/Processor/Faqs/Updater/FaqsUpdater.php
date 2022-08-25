<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Updater;

use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Pyz\Client\FaqsRestApi\FaqsRestApiClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class FaqsUpdater implements FaqsUpdaterInterface {


    protected FaqsRestApiClientInterface $faqsRestApiClient;
    protected RestResourceBuilderInterface $restResourceBuilder;

    public function __construct(
        FaqsRestApiClientInterface $faqsRestApiClient,
        RestResourceBuilderInterface   $restResourceBuilder
    ){

        $this->faqsRestApiClient = $faqsRestApiClient;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    public function updateFaqEntity(RestRequestInterface $restRequest, FaqTransfer $trans): RestResponseInterface {
        $response = $this->restResourceBuilder->createRestResponse();

        $res = $this->faqsRestApiClient
            ->updateFaqEntity($trans);

        if($res) {
            return $response->addError(
                (new RestErrorMessageTransfer())
                    ->setCode('Updated successfully')
                    ->setStatus(201)
            );
        }

        return $response->addError(
            (new RestErrorMessageTransfer())
                ->setCode('An error occurred while updating')
                ->setStatus(500)
        );
    }
}
