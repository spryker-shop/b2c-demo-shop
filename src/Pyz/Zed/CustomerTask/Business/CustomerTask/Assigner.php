<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\CustomerTask;

use Generated\Shared\Transfer\CustomerCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskConditionsTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Pyz\Zed\CustomerTask\Business\Exception\CustomerNotFoundException;
use Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException;
use Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface;
use Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class Assigner implements AssignerInterface
{
    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    private CustomerFacadeInterface $customerFacade;

    /**
     * @var \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface
     */
    private CustomerTaskRepositoryInterface $customerTaskRepository;

    /**
     * @var \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface
     */
    private CustomerTaskEntityManagerInterface $customerTaskEntityManager;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     * @param \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface $customerTaskRepository
     * @param \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface $customerTaskEntityManager
     */
    public function __construct(
        CustomerFacadeInterface $customerFacade,
        CustomerTaskRepositoryInterface $customerTaskRepository,
        CustomerTaskEntityManagerInterface $customerTaskEntityManager,
    ) {
        $this->customerFacade = $customerFacade;
        $this->customerTaskRepository = $customerTaskRepository;
        $this->customerTaskEntityManager = $customerTaskEntityManager;
    }

    /**
     * @param string $customerEmail
     * @param int $idCustomerTask
     *
     * @throws \Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function assign(string $customerEmail, int $idCustomerTask): CustomerTaskTransfer
    {
        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setIdCustomerTask($idCustomerTask),
        );

        $customerTaskTransfer = $this->customerTaskRepository->findOne($customerTaskCriteriaTransfer);

        if (!$customerTaskTransfer) {
            throw new CustomerTaskNotFoundException();
        }

        $customerTaskTransfer->setFkOwner(
            $this->getCustomerIdByEmail($customerEmail),
        );

        return $this->customerTaskEntityManager->update($customerTaskTransfer);
    }

    /**
     * @param string $customerEmail
     *
     * @throws \Pyz\Zed\CustomerTask\Business\Exception\CustomerNotFoundException
     *
     * @return int
     */
    private function getCustomerIdByEmail(string $customerEmail): int
    {
        $customerResponseTransfer = $this->customerFacade->getCustomerByCriteria(
            (new CustomerCriteriaTransfer())->setEmail($customerEmail),
        );

        if (!$customerResponseTransfer->getIsSuccess()) {
            throw new CustomerNotFoundException();
        }

        return $customerResponseTransfer->getCustomerTransfer()->getIdCustomer();
    }
}
