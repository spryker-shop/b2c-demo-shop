<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\Mapper;

use Generated\Shared\Transfer\CustomerTaskTransfer;
use Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer;

interface CustomerTaskMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     * @param \Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer $customerTaskAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer
     */
    public function mapCustomerTaskTransferToRestCustomerTaskAttributesTransfer(
        CustomerTaskTransfer $customerTaskTransfer,
        RestCustomerTaskAttributesTransfer $customerTaskAttributesTransfer,
    ): RestCustomerTaskAttributesTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer $customerTaskAttributesTransfer
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function mapRestCustomerTaskAttributesTransferToCustomerTaskTransfer(
        RestCustomerTaskAttributesTransfer $customerTaskAttributesTransfer,
        CustomerTaskTransfer $customerTaskTransfer,
    ): CustomerTaskTransfer;
}
