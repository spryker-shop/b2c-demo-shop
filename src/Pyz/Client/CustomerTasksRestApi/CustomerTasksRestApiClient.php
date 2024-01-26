<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CustomerTasksRestApi;

use Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskResponseTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer;
use Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiFactory getFactory()
 */
class CustomerTasksRestApiClient extends AbstractClient implements CustomerTasksRestApiClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionResponseTransfer
    {
        return $this->getFactory()->createCustomerTasksRestApiZedStub()->get($customerTaskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function getOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskResponseTransfer
    {
        return $this->getFactory()->createCustomerTasksRestApiZedStub()->getOne($customerTaskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        return $this->getFactory()->createCustomerTasksRestApiZedStub()->create($customerTaskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        return $this->getFactory()->createCustomerTasksRestApiZedStub()->update($customerTaskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        return $this->getFactory()->createCustomerTasksRestApiZedStub()->delete($customerTaskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function assign(RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer): CustomerTaskResponseTransfer
    {
        return $this->getFactory()->createCustomerTasksRestApiZedStub()->assign($restCustomerTaskAssignRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function addTag(RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer): CustomerTaskResponseTransfer
    {
        return $this->getFactory()->createCustomerTasksRestApiZedStub()->addTag($restCustomerTaskTagRequestTransfer);
    }
}
