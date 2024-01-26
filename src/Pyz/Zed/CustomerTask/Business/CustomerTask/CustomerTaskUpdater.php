<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\CustomerTask;

use Generated\Shared\Transfer\CustomerTaskTransfer;
use Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface;

class CustomerTaskUpdater implements CustomerTaskUpdaterInterface
{
    /**
     * @var \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface
     */
    private CustomerTaskEntityManagerInterface $customerTaskEntityManager;

    /**
     * @param \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface $customerTaskEntityManager
     */
    public function __construct(CustomerTaskEntityManagerInterface $customerTaskEntityManager)
    {
        $this->customerTaskEntityManager = $customerTaskEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer
    {
        return $this->customerTaskEntityManager->update($customerTaskTransfer);
    }
}
