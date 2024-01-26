<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder;

use ArrayObject;
use Generated\Shared\Transfer\CustomerTaskCollectionTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Pyz\Glue\CustomerTasksRestApi\CustomerTasksRestApiConfig;
use Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class CustomerTaskRestResponseBuilder implements CustomerTaskRestResponseBuilderInterface
{
    /**
     * @var \Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface
     */
    private CustomerTaskMapperInterface $customerTaskMapper;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    private RestResourceBuilderInterface $restResourceBuilder;

    /**
     * @param \Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface $customerTaskMapper
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        CustomerTaskMapperInterface $customerTaskMapper,
        RestResourceBuilderInterface $restResourceBuilder,
    ) {
        $this->customerTaskMapper = $customerTaskMapper;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createMissingAccessTokenErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(CustomerTasksRestApiConfig::RESPONSE_CODE_ACCESS_CODE_INVALID)
            ->setStatus(Response::HTTP_FORBIDDEN)
            ->setDetail(CustomerTasksRestApiConfig::RESPONSE_DETAIL_INVALID_ACCESS_TOKEN);

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorMessageTransfer);
    }

    /**
     * @param \ArrayObject<int,\Generated\Shared\Transfer\MessageTransfer> $errorMessages
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createRestErrorResponse(ArrayObject $errorMessages): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode((string)Response::HTTP_BAD_REQUEST)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(CustomerTasksRestApiConfig::RESPONSE_UNKNOWN_ERROR);

        foreach ($errorMessages as $errorMessage) {
            $restErrorMessageTransfer->setStatus(Response::HTTP_BAD_REQUEST)
                ->setDetail($errorMessage->getMessage());

            return $this->restResourceBuilder->createRestResponse()->addError($restErrorMessageTransfer);
        }

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCollectionTransfer $customerTaskCollectionTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCustomerTaskCollectionRestResponse(
        CustomerTaskCollectionTransfer $customerTaskCollectionTransfer,
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        foreach ($customerTaskCollectionTransfer->getCustomerTasks() as $customerTaskTransfer) {
            $restResponse->addResource($this->createCustomerTasksResource($customerTaskTransfer));
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer|null $customerTaskTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCustomerTaskRestResponse(
        ?CustomerTaskTransfer $customerTaskTransfer = null,
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        if (!$customerTaskTransfer) {
            return $restResponse;
        }

        return $restResponse->addResource(
            $this->createCustomerTasksResource($customerTaskTransfer),
        );
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createEmptyResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse();
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    private function createCustomerTasksResource(CustomerTaskTransfer $customerTaskTransfer): RestResourceInterface
    {
        $restCustomerTaskAttributesTransfer = $this->customerTaskMapper
            ->mapCustomerTaskTransferToRestCustomerTaskAttributesTransfer(
                $customerTaskTransfer,
                new RestCustomerTaskAttributesTransfer(),
            );
        /** @var string $idCustomerTask */
        $idCustomerTask = $customerTaskTransfer->getIdCustomerTask();

        return $this->restResourceBuilder->createRestResource(
            CustomerTasksRestApiConfig::RESOURCE_CUSTOMER_TASKS,
            $idCustomerTask,
            $restCustomerTaskAttributesTransfer,
        );
    }
}
