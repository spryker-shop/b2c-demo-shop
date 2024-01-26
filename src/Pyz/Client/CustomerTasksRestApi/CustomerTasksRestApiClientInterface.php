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

interface CustomerTasksRestApiClientInterface
{
    /**
     * Specification:
     *  - Makes Zed request.
     *  - Returns response transfer with Customer Task collection by given criteria.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Returns response transfer with Customer Task by given criteria.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function getOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Creates Customer Task and stores it to database.
     * - Returns response transfer with created Customer Task.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Updated Customer Task with provided data.
     * - Returns response transfer with created Customer Task.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Deletes Customer Task from database.
     * - Returns response transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Assigns Customer to Customer Task.
     * - Returns response transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function assign(RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer): CustomerTaskResponseTransfer;

    /**
     * Specification:
     * - Makes Zed request.
     * - Adds tag to Customer Task.
     * - Returns response transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function addTag(RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer): CustomerTaskResponseTransfer;
}
