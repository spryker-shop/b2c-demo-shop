<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Reader;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Pyz\Client\FaqsRestApi\FaqClientInterface;
use Pyz\Glue\FaqsRestApi\FaqsRestApiConfig;
use Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapper;
use Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class FaqsReader implements FaqsReaderInterface
{
    /** @var \Pyz\Client\FaqsRestApi\FaqClientInterface */
    private FaqClientInterface $faqsRestApiClient;

    /** @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface */
    private RestResourceBuilderInterface $restResourceBuilder;

    /** @var \Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapper */
    private FaqsResourceMapper $faqMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapperInterface $faqMapper
     */
    public function __construct(
        FaqClientInterface $faqsRestApiClient,
        RestResourceBuilderInterface   $restResourceBuilder,
        FaqsResourceMapperInterface $faqMapper
    )
    {
        $this->faqsRestApiClient = $faqsRestApiClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->faqMapper = $faqMapper;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getFaqs(RestRequestInterface $restRequest): RestResponseInterface
    {

        $restResponse = $this->restResourceBuilder->createRestResponse();

        $planetCollectionTransfer =
            $this->faqsRestApiClient->getFaqCollection(new FaqCollectionTransfer());


        foreach ($planetCollectionTransfer->getFaqs() as $faqTransfer) {
            $restResource = $this->restResourceBuilder->createRestResource(
                FaqsRestApiConfig::RESOURCE_FAQS,
                $faqTransfer->getIdFaq(),
                $this->faqMapper->mapFaqDataToFaqRestAttributes($faqTransfer)
            );
            $restResponse->addResource($restResource);
        }

        return $restResponse;
    }

    public function getFaq(RestRequestInterface $restRequest, int $id): RestResponseInterface {

        $restResponse = $this->restResourceBuilder->createRestResponse();

        $res =
            $this->faqsRestApiClient->getFaqEntity(
                (new FaqTransfer())->setIdFaq($id)
            );

        if($res === null) {
            $restResponse->addError((new RestErrorMessageTransfer())
                ->setCode('Entity with given id not found')
                ->setStatus(404));

            return $restResponse;
        }

        $restResource = $this->restResourceBuilder->createRestResource(
            FaqsRestApiConfig::RESOURCE_FAQS,
            $res->getIdFaq(),
            $this->faqMapper->mapFaqDataToFaqRestAttributes($res)
        );
        $restResponse->addResource($restResource);

        return $restResponse;
    }
}


