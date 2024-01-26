<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CustomerTaskCollectionTransfer;
use Generated\Shared\Transfer\CustomerTaskTagTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Orm\Zed\CustomerTask\Persistence\PyzCustomerTask;
use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskTag;
use Propel\Runtime\Collection\ObjectCollection;

class CustomerTaskMapper
{
    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $customerTaskEntities
     * @param \Generated\Shared\Transfer\CustomerTaskCollectionTransfer $customerTaskCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionTransfer
     */
    public function mapCustomerTaskEntitiesToCustomerTaskCollectionTransfer(
        ObjectCollection $customerTaskEntities,
        CustomerTaskCollectionTransfer $customerTaskCollectionTransfer,
    ): CustomerTaskCollectionTransfer {
        foreach ($customerTaskEntities as $customerTaskEntity) {
            $customerTaskCollectionTransfer->addCustomerTask(
                $this->mapCustomerTaskEntityToCustomerTaskTransfer(
                    $customerTaskEntity,
                    new CustomerTaskTransfer(),
                ),
            );
        }

        return $customerTaskCollectionTransfer;
    }

    /**
     * @param \Orm\Zed\CustomerTask\Persistence\PyzCustomerTask $customerTaskEntity
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function mapCustomerTaskEntityToCustomerTaskTransfer(
        PyzCustomerTask $customerTaskEntity,
        CustomerTaskTransfer $customerTaskTransfer,
    ): CustomerTaskTransfer {
        $customerTaskTransfer->fromArray($customerTaskEntity->toArray(), true);
        foreach ($customerTaskEntity->getPyzCustomerTaskTagRelationsJoinPyzCustomerTaskTag() as $entity) {
            $customerTaskTagTransfer = $this->mapCustomerTaskTagEntityToCustomerTaskTagTransfer(
                $entity->getPyzCustomerTaskTag(),
                new CustomerTaskTagTransfer(),
            );

            $customerTaskTransfer->addTag($customerTaskTagTransfer);
        }

        return $customerTaskTransfer;
    }

    /**
     * @param \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskTag $customerTaskTagEntity
     * @param \Generated\Shared\Transfer\CustomerTaskTagTransfer $customerTaskTagTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTagTransfer
     */
    public function mapCustomerTaskTagEntityToCustomerTaskTagTransfer(
        PyzCustomerTaskTag $customerTaskTagEntity,
        CustomerTaskTagTransfer $customerTaskTagTransfer,
    ): CustomerTaskTagTransfer {
        return $customerTaskTagTransfer->fromArray($customerTaskTagEntity->toArray(), true);
    }
}
