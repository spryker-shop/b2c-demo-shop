<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks;

use Generated\Shared\Transfer\CustomerTaskTransfer;
use Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer;
use Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerTaskUpdater implements CustomerTaskUpdaterInterface
{
    /**
     * @var \Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface
     */
    private CustomerTasksRestApiClientInterface $customerTasksRestApiClient;

    /**
     * @var \Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface
     */
    private CustomerTaskRestResponseBuilderInterface $customerTaskRestResponseBuilder;

    /**
     * @var \Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface
     */
    private CustomerTaskMapperInterface $customerTaskMapper;

    /**
     * @param \Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface $customerTasksRestApiClient
     * @param \Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface $customerTaskRestResponseBuilder
     * @param \Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface $customerTaskMapper
     */
    public function __construct(
        CustomerTasksRestApiClientInterface $customerTasksRestApiClient,
        CustomerTaskRestResponseBuilderInterface $customerTaskRestResponseBuilder,
        CustomerTaskMapperInterface $customerTaskMapper,
    ) {
        $this->customerTasksRestApiClient = $customerTasksRestApiClient;
        $this->customerTaskRestResponseBuilder = $customerTaskRestResponseBuilder;
        $this->customerTaskMapper = $customerTaskMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function update(
        RestCustomerTaskAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestResponseInterface {
        if (!$restRequest->getRestUser()) {
            return $this->customerTaskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $customerTaskTransfer = $this->createCustomerTaskTransfer($attributesTransfer, $restRequest);
        $customerTaskResponseTransfer = $this->customerTasksRestApiClient->update($customerTaskTransfer);

        if (!$customerTaskResponseTransfer->getIsSuccessful()) {
            return $this->customerTaskRestResponseBuilder->createRestErrorResponse(
                $customerTaskResponseTransfer->getMessages(),
            );
        }

        return $this->customerTaskRestResponseBuilder->createCustomerTaskRestResponse(
            $customerTaskResponseTransfer->getCustomerTask(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    private function createCustomerTaskTransfer(
        RestCustomerTaskAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): CustomerTaskTransfer {
        $customerTaskTransfer = $this->customerTaskMapper->mapRestCustomerTaskAttributesTransferToCustomerTaskTransfer(
            $attributesTransfer,
            new CustomerTaskTransfer(),
        );

        $idCustomerTask = (int)$restRequest->getResource()->getId();
        $customerTaskTransfer->setIdCustomerTask($idCustomerTask);

        return $customerTaskTransfer;
    }
}
