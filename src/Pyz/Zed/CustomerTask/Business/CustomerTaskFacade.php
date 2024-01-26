<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business;

use Generated\Shared\Transfer\CustomerTaskCollectionTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\CustomerTask\Business\CustomerTaskBusinessFactory getFactory()
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface getEntityManager()
 */
class CustomerTaskFacade extends AbstractFacade implements CustomerTaskFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionTransfer
    {
        return $this->getFactory()->createCustomerTaskReader()->get($customerTaskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer|null
     */
    public function findOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): ?CustomerTaskTransfer
    {
        return $this->getFactory()->createCustomerTaskReader()->findOne($customerTaskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer
    {
        return $this->getFactory()->createCustomerTaskCreator()->create($customerTaskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer
    {
        return $this->getFactory()->createCustomerTaskUpdater()->update($customerTaskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return bool
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): bool
    {
        return $this->getFactory()->createCustomerTaskDeleter()->delete($customerTaskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function notifyCustomersAboutOverdueTasks(): void
    {
        $this->getFactory()->createOverdueTaskNotifier()->notify();
    }

    /**
     * {@inheritDoc}
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
    public function assign(string $customerEmail, int $idCustomerTask): CustomerTaskTransfer
    {
        return $this->getFactory()->createAssigner()->assign($customerEmail, $idCustomerTask);
    }

    /**
     * {@inheritDoc}
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
    public function addTag(string $tag, int $idCustomerTask): CustomerTaskTransfer
    {
        return $this->getFactory()->createTagAdder()->addTag($tag, $idCustomerTask);
    }
}
