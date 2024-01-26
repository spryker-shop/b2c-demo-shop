<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Persistence;

use Generated\Shared\Transfer\CustomerTaskTagTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Orm\Zed\CustomerTask\Persistence\PyzCustomerTask;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskPersistenceFactory getFactory()
 */
class CustomerTaskEntityManager extends AbstractEntityManager implements CustomerTaskEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function create(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer
    {
        $this->validateRequiredFields($customerTaskTransfer);

        $customerTaskEntity = (new PyzCustomerTask())->fromArray($customerTaskTransfer->toArray());
        $customerTaskEntity->save();

        return $this->getFactory()
            ->creatCustomerTaskMapper()
            ->mapCustomerTaskEntityToCustomerTaskTransfer(
                $customerTaskEntity,
                $customerTaskTransfer,
            );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function update(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskTransfer
    {
        $this->validateRequiredFields($customerTaskTransfer);

        $customerTaskEntity = $this->getFactory()
            ->getCustomerTaskPropelQuery()
            ->filterByIdCustomerTask($customerTaskTransfer->getIdCustomerTaskOrFail())
            ->findOne();

        $customerTaskEntity->fromArray($customerTaskTransfer->toArray());
        $customerTaskEntity->save();

        return $this->getFactory()
            ->creatCustomerTaskMapper()
            ->mapCustomerTaskEntityToCustomerTaskTransfer(
                $customerTaskEntity,
                $customerTaskTransfer,
            );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return bool
     */
    public function delete(CustomerTaskTransfer $customerTaskTransfer): bool
    {
        return (bool)$this->getFactory()
            ->getCustomerTaskPropelQuery()
            ->filterByIdCustomerTask($customerTaskTransfer->getIdCustomerTaskOrFail())
            ->delete();
    }

    /**
     * @param string $tag
     * @param int $idCustomerTask
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTagTransfer
     */
    public function addTag(string $tag, int $idCustomerTask): CustomerTaskTagTransfer
    {
        $customerTaskTagEntity = $this->getFactory()->getCustomerTaskTagPropelQuery()
            ->filterByTag($tag)
            ->findOneOrCreate();

        $customerTaskTagEntity->save();

        $customerTaskTagRelationEntity = $this->getFactory()->getCustomerTaskTagRelationPropelQuery()
            ->filterByFkCustomerTask($idCustomerTask)
            ->filterByFkCustomerTaskTag($customerTaskTagEntity->getIdCustomerTaskTag())
            ->findOneOrCreate();

        $customerTaskTagRelationEntity->save();

        return $this->getFactory()
            ->creatCustomerTaskMapper()
            ->mapCustomerTaskTagEntityToCustomerTaskTagTransfer(
                $customerTaskTagEntity,
                new CustomerTaskTagTransfer(),
            );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return void
     */
    private function validateRequiredFields(CustomerTaskTransfer $customerTaskTransfer): void
    {
        $customerTaskTransfer->requireFkCreator()
            ->requireTitle()
            ->requireDescription()
            ->requireDueDate()
            ->requireStatus();
    }
}
