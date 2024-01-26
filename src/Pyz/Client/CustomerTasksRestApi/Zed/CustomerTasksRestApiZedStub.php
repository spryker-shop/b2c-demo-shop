<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CustomerTasksRestApi\Zed;

use Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskResponseTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer;
use Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CustomerTasksRestApiZedStub implements CustomerTasksRestApiZedStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    private ZedRequestClientInterface $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @uses \Pyz\Zed\CustomerTasksRestApi\Communication\Controller\GatewayController::getAction()
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer $customerTaskCollectionResponseTransfer */
        $customerTaskCollectionResponseTransfer = $this->zedRequestClient->call('/customer-tasks-rest-api/gateway/get', $customerTaskCriteriaTransfer);

        return $customerTaskCollectionResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\CustomerTasksRestApi\Communication\Controller\GatewayController::getOneAction()
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function getOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerTaskResponseTransfer $customerTaskResponseTransfer */
        $customerTaskResponseTransfer = $this->zedRequestClient->call('/customer-tasks-rest-api/gateway/get-one', $customerTaskCriteriaTransfer);

        return $customerTaskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\CustomerTasksRestApi\Communication\Controller\GatewayController::createAction()
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerTaskResponseTransfer $customerTaskResponseTransfer */
        $customerTaskResponseTransfer = $this->zedRequestClient->call('/customer-tasks-rest-api/gateway/create', $customerTaskTransfer);

        return $customerTaskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\CustomerTasksRestApi\Communication\Controller\GatewayController::updateAction()
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerTaskResponseTransfer $customerTaskResponseTransfer */
        $customerTaskResponseTransfer = $this->zedRequestClient->call('/customer-tasks-rest-api/gateway/update', $customerTaskTransfer);

        return $customerTaskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\CustomerTasksRestApi\Communication\Controller\GatewayController::deleteAction()
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerTaskResponseTransfer $customerTaskResponseTransfer */
        $customerTaskResponseTransfer = $this->zedRequestClient->call('/customer-tasks-rest-api/gateway/delete', $customerTaskTransfer);

        return $customerTaskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\CustomerTasksRestApi\Communication\Controller\GatewayController::assignAction()
     *
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function assign(RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer): CustomerTaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerTaskResponseTransfer $customerTaskResponseTransfer */
        $customerTaskResponseTransfer = $this->zedRequestClient->call('/customer-tasks-rest-api/gateway/assign', $restCustomerTaskAssignRequestTransfer);

        return $customerTaskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\CustomerTasksRestApi\Communication\Controller\GatewayController::addTagAction()
     *
     * @param \Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function addTag(RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer): CustomerTaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\CustomerTaskResponseTransfer $customerTaskResponseTransfer */
        $customerTaskResponseTransfer = $this->zedRequestClient->call('/customer-tasks-rest-api/gateway/add-tag', $restCustomerTaskTagRequestTransfer);

        return $customerTaskResponseTransfer;
    }
}
