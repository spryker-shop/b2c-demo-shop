<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\Assign;

use Generated\Shared\Transfer\RestCustomerTaskAssignAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer;
use Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerTaskAssigner implements CustomerTaskAssignerInterface
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
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function assign(
        RestCustomerTaskAssignAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestResponseInterface {
        if (!$restRequest->getRestUser()) {
            return $this->customerTaskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $restCustomerTaskAssignRequestTransfer = $this->createRestCustomerTaskAssignRequestTransfer(
            $attributesTransfer,
            $restRequest,
        );
        $customerTaskResponseTransfer = $this->customerTasksRestApiClient->assign($restCustomerTaskAssignRequestTransfer);

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
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer
     */
    private function createRestCustomerTaskAssignRequestTransfer(
        RestCustomerTaskAssignAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestCustomerTaskAssignRequestTransfer {
        $idCustomerTask = (int)$restRequest->getResource()->getId();

        return (new RestCustomerTaskAssignRequestTransfer())
            ->setIdCustomerTask($idCustomerTask)
            ->setEmail($attributesTransfer->getEmail());
    }
}
