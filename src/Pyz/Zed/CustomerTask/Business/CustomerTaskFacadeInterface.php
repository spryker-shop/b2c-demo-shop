<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business;

use Generated\Shared\Transfer\CustomerTaskCollectionTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;

interface CustomerTaskFacadeInterface
{
    /**
     * Specification:
     * - Returns Customer Task Collection by given criteria.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionTransfer;

    /**
     *  Specification:
     *  - Returns Customer Task Transfer by given criteria.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer|null
     */
    public function findOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): ?CustomerTaskTransfer;

    /**
     * Specification:
     *  - Creates and store Customer Task to database.
     *  - Returns Customer Task Transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer;

    /**
     * Specification:
     *  - Updates Customer Task.
     *  - Returns Customer Task Transfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer;

    /**
     * Specification:
     *  - Deletes Customer Task.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return bool
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): bool;

    /**
     * Specification:
     *  - Retrieves collection of overdue Customer Tasks.
     *  - Sends email to creator of Customer Tasks.
     *
     * @api
     *
     * @return void
     */
    public function notifyCustomersAboutOverdueTasks(): void;

    /**
     * Specification:
     *  - Assigns Customer Task Owner.
     *  - Returns Customer Task Transfer.
     *
     * @api
     *
     * @param string $customerEmail
     * @param int $idCustomerTask
     *
     * @throws \Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function assign(string $customerEmail, int $idCustomerTask): CustomerTaskTransfer;

    /**
     * Specification:
     *  - Stores Customer Task Tag to database.
     *  - Creates relation between Customer Task and Customer Task Tag.
     *  - Returns Customer Task Transfer.
     *
     * @api
     *
     * @param string $tag
     * @param int $idCustomerTask
     *
     * @throws \Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function addTag(string $tag, int $idCustomerTask): CustomerTaskTransfer;
}
