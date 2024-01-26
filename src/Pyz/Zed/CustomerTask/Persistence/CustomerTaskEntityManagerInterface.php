<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Persistence;

use Generated\Shared\Transfer\CustomerTaskTagTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;

interface CustomerTaskEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return bool
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): bool;

    /**
     * @param string $tag
     * @param int $idCustomerTask
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTagTransfer
     */
    public function addTag(string $tag, int $idCustomerTask): CustomerTaskTagTransfer;
}
