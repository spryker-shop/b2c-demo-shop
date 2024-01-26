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

interface CustomerTasksRestApiZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function getOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function assign(RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer): CustomerTaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function addTag(RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer): CustomerTaskResponseTransfer;
}
