<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\CustomerTaskTag;

use Generated\Shared\Transfer\CustomerTaskConditionsTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException;
use Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface;
use Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface;

class TagAdder implements TagAdderInterface
{
    /**
     * @var \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface
     */
    private CustomerTaskRepositoryInterface $customerTaskRepository;

    /**
     * @var \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface
     */
    private CustomerTaskEntityManagerInterface $customerTaskEntityManager;

    /**
     * @param \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface $customerTaskRepository
     * @param \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface $customerTaskEntityManager
     */
    public function __construct(
        CustomerTaskRepositoryInterface $customerTaskRepository,
        CustomerTaskEntityManagerInterface $customerTaskEntityManager,
    ) {
        $this->customerTaskRepository = $customerTaskRepository;
        $this->customerTaskEntityManager = $customerTaskEntityManager;
    }

    /**
     * @param string $tag
     * @param int $idCustomerTask
     *
     * @throws \Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function addTag(string $tag, int $idCustomerTask): CustomerTaskTransfer
    {
        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setIdCustomerTask($idCustomerTask),
        );

        $customerTaskTransfer = $this->customerTaskRepository->findOne($customerTaskCriteriaTransfer);

        if (!$customerTaskTransfer) {
            throw new CustomerTaskNotFoundException();
        }

        $customerTaskTagTransfer = $this->customerTaskEntityManager->addTag($tag, $idCustomerTask);
        $customerTaskTransfer->addTag($customerTaskTagTransfer);

        return $customerTaskTransfer;
    }
}
