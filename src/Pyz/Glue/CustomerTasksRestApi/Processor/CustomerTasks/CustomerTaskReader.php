<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks;

use Generated\Shared\Transfer\CustomerTaskConditionsTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class CustomerTaskReader implements CustomerTaskReaderInterface
{
    /**
     * @var string
     */
    private const REQUEST_PARAMETER_PAGE = 'page';

    /**
     * @var string
     */
    private const REQUEST_PARAMETER_TITLE = 'title';

    /**
     * @var string
     */
    private const REQUEST_PARAMETER_DESCRIPTION = 'description';

    /**
     * @var string
     */
    private const REQUEST_PARAMETER_TAG = 'tag';

    /**
     * @uses \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepository::DEFAULT_PAGINATION_PAGE
     *
     * @var int
     */
    private const DEFAULT_PAGINATION_PAGE = 1;

    /**
     * @uses \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepository::DEFAULT_PAGINATION_MAX_PER_PAGE
     *
     * @var int
     */
    private const DEFAULT_PAGINATION_MAX_PER_PAGE = 10;

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
    public function get(RestRequestInterface $restRequest): RestResponseInterface
    {
        if (!$restRequest->getRestUser()) {
            return $this->customerTaskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $idCustomerTask = (int)$restRequest->getResource()->getId();

        if ($idCustomerTask) {
            return $this->getCustomerTask($idCustomerTask);
        }

        return $this->getCustomerTaskCollection($restRequest);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    private function getCustomerTaskCollection(RestRequestInterface $restRequest): RestResponseInterface
    {
        $customerTaskCriteriaTransfer = $this->createCustomerTaskCriteriaTransfer($restRequest);
        $customerTaskCollectionResponseTransfer = $this->customerTasksRestApiClient->get($customerTaskCriteriaTransfer);

        if (!$customerTaskCollectionResponseTransfer->getIsSuccessful()) {
            return $this->customerTaskRestResponseBuilder->createRestErrorResponse(
                $customerTaskCollectionResponseTransfer->getMessages(),
            );
        }

        return $this->customerTaskRestResponseBuilder->createCustomerTaskCollectionRestResponse(
            $customerTaskCollectionResponseTransfer->getCustomerTasks(),
        );
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer
     */
    private function createCustomerTaskCriteriaTransfer(RestRequestInterface $restRequest): CustomerTaskCriteriaTransfer
    {
        $customerTaskCriteriaTransfer = new CustomerTaskCriteriaTransfer();
        $page = (int)$restRequest->getHttpRequest()->get(
            self::REQUEST_PARAMETER_PAGE,
            self::DEFAULT_PAGINATION_PAGE,
        );

        $customerTaskCriteriaTransfer->setPagination(
            (new PaginationTransfer())->setPage($page)
                ->setMaxPerPage(self::DEFAULT_PAGINATION_MAX_PER_PAGE),
        );

        $title = $restRequest->getHttpRequest()->get(self::REQUEST_PARAMETER_TITLE);
        $description = $restRequest->getHttpRequest()->get(self::REQUEST_PARAMETER_DESCRIPTION);
        $tag = $restRequest->getHttpRequest()->get(self::REQUEST_PARAMETER_TAG);

        if (!$title && !$description && !$tag) {
            return $customerTaskCriteriaTransfer;
        }

        $customerTaskConditionsTransfer = new CustomerTaskConditionsTransfer();
        if ($title) {
            $customerTaskConditionsTransfer->setTitle($title);
        }
        if ($description) {
            $customerTaskConditionsTransfer->setDescription($description);
        }
        if ($tag) {
            $customerTaskConditionsTransfer->setTag($tag);
        }

        $customerTaskCriteriaTransfer->setCustomerTaskConditions($customerTaskConditionsTransfer);

        return $customerTaskCriteriaTransfer;
    }

    /**
     * @param int $idCustomerTask
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    private function getCustomerTask(int $idCustomerTask): RestResponseInterface
    {
        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())
            ->setCustomerTaskConditions(
                (new CustomerTaskConditionsTransfer())->setIdCustomerTask($idCustomerTask),
            );
        $customerTaskResponseTransfer = $this->customerTasksRestApiClient->getOne($customerTaskCriteriaTransfer);

        if (!$customerTaskResponseTransfer->getIsSuccessful()) {
            return $this->customerTaskRestResponseBuilder->createRestErrorResponse(
                $customerTaskResponseTransfer->getMessages(),
            );
        }

        return $this->customerTaskRestResponseBuilder->createCustomerTaskRestResponse(
            $customerTaskResponseTransfer->getCustomerTask(),
        );
    }
}
