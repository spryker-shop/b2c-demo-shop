<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks;

use Generated\Shared\Transfer\CustomerTaskTransfer;
use Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerTaskDeleter implements CustomerTaskDeleterInterface
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
     * @param \Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface $customerTasksRestApiClient
     * @param \Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface $customerTaskRestResponseBuilder
     */
    public function __construct(
        CustomerTasksRestApiClientInterface $customerTasksRestApiClient,
        CustomerTaskRestResponseBuilderInterface $customerTaskRestResponseBuilder,
    ) {
        $this->customerTasksRestApiClient = $customerTasksRestApiClient;
        $this->customerTaskRestResponseBuilder = $customerTaskRestResponseBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function delete(RestRequestInterface $restRequest): RestResponseInterface
    {
        if (!$restRequest->getRestUser()) {
            return $this->customerTaskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $idCustomerTask = (int)$restRequest->getResource()->getId();
        $customerTaskTransfer = (new CustomerTaskTransfer())->setIdCustomerTask($idCustomerTask);
        $customerTaskResponseTransfer = $this->customerTasksRestApiClient->delete($customerTaskTransfer);

        if (!$customerTaskResponseTransfer->getIsSuccessful()) {
            return $this->customerTaskRestResponseBuilder->createRestErrorResponse(
                $customerTaskResponseTransfer->getMessages(),
            );
        }

        return $this->customerTaskRestResponseBuilder->createEmptyResponse();
    }
}
