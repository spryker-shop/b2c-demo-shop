<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Planets;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Pyz\Client\FaqsRestApi\FaqsRestApiClientInterface;
use Pyz\Glue\FaqsRestApi\FaqsRestApiConfig;
use Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapperInterface;
use Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapper;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class FaqsReader implements FaqsReaderInterface
{
    /** @var \Pyz\Client\FaqsRestApi\FaqsRestApiClientInterface */
    private FaqsRestApiClientInterface $faqsRestApiClient;

    /** @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface */
    private RestResourceBuilderInterface $restResourceBuilder;

    /** @var \Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapper */
    private FaqsResourceMapper $faqMapper;

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapperInterface $faqMapper
     */
    public function __construct(
        FaqsRestApiClientInterface $faqsRestApiClient,
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

        //var_dump($planetCollectionTransfer);
        //die();

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
}


