<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\CustomerTask;

use Generated\Shared\Transfer\CustomerTaskCollectionTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface;

class CustomerTaskReader implements CustomerTaskReaderInterface
{
    /**
     * @var \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface
     */
    private CustomerTaskRepositoryInterface $customerTaskRepository;

    /**
     * @param \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface $customerTaskRepository
     */
    public function __construct(CustomerTaskRepositoryInterface $customerTaskRepository)
    {
        $this->customerTaskRepository = $customerTaskRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionTransfer
    {
        return $this->customerTaskRepository->get($customerTaskCriteriaTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer|null
     */
    public function findOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): ?CustomerTaskTransfer
    {
        return $this->customerTaskRepository->findOne($customerTaskCriteriaTransfer);
    }
}
