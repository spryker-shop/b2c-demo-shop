<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTaskTag;

use Generated\Shared\Transfer\RestCustomerTaskTagAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer;
use Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerTaskTagAdder implements CustomerTaskTagAdderInterface
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
     * @param \Generated\Shared\Transfer\RestCustomerTaskTagAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function addTag(
        RestCustomerTaskTagAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestResponseInterface {
        if (!$restRequest->getRestUser()) {
            return $this->customerTaskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $restCustomerTaskAssignRequestTransfer = $this->createRestCustomerTaskTagRequestTransfer(
            $attributesTransfer,
            $restRequest,
        );
        $customerTaskResponseTransfer = $this->customerTasksRestApiClient->addTag($restCustomerTaskAssignRequestTransfer);

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
     * @param \Generated\Shared\Transfer\RestCustomerTaskTagAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer
     */
    private function createRestCustomerTaskTagRequestTransfer(
        RestCustomerTaskTagAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestCustomerTaskTagRequestTransfer {
        $idCustomerTask = (int)$restRequest->getResource()->getId();

        return (new RestCustomerTaskTagRequestTransfer())
            ->setIdCustomerTask($idCustomerTask)
            ->setTag($attributesTransfer->getTag());
    }
}
