<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Persistence;

use DateTime;
use Generated\Shared\Transfer\CustomerTaskCollectionTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria as SprykerCriteria;

/**
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskPersistenceFactory getFactory()
 */
class CustomerTaskRepository extends AbstractRepository implements CustomerTaskRepositoryInterface
{
    /**
     * @var int
     */
    private const DEFAULT_PAGINATION_MAX_PER_PAGE = 10;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionTransfer
     */
    public function get(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionTransfer
    {
        $customerTaskQuery = $this->getFactory()->getCustomerTaskPropelQuery();
        $customerTaskQuery = $this->applyCriteria($customerTaskCriteriaTransfer, $customerTaskQuery);
        $customerTaskQuery = $this->applyPagination($customerTaskCriteriaTransfer, $customerTaskQuery);

        $customerTaskCollectionTransfer = (new CustomerTaskCollectionTransfer())->setPagination(
            $customerTaskCriteriaTransfer->getPagination(),
        );

        return $this->getFactory()->createCustomerTaskMapper()->mapCustomerTaskEntitiesToCustomerTaskCollectionTransfer(
            $customerTaskQuery->find(),
            $customerTaskCollectionTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer|null
     */
    public function findOne(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): ?CustomerTaskTransfer
    {
        $customerTaskQuery = $this->getFactory()->getCustomerTaskPropelQuery();
        $customerTaskQuery = $this->applyCriteria($customerTaskCriteriaTransfer, $customerTaskQuery);

        $customerTaskEntity = $customerTaskQuery->findOne();

        if (!$customerTaskEntity) {
            return null;
        }

        return $this->getFactory()->createCustomerTaskMapper()->mapCustomerTaskEntityToCustomerTaskTransfer(
            $customerTaskEntity,
            new CustomerTaskTransfer(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     * @param \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery $customerTaskQuery
     *
     * @return \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery
     */
    private function applyCriteria(
        CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer,
        PyzCustomerTaskQuery $customerTaskQuery,
    ): PyzCustomerTaskQuery {
        if (!$customerTaskCriteriaTransfer->getCustomerTaskConditions()) {
            return $customerTaskQuery;
        }

        if ($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getIdCustomerTask() !== null) {
            $customerTaskQuery->filterByIdCustomerTask(
                $customerTaskCriteriaTransfer->getCustomerTaskConditions()
                    ->getIdCustomerTask(),
            );
        }

        if (count($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getCustomerTaskIds()) > 0) {
            $customerTaskQuery->filterByIdCustomerTask_In(
                $customerTaskCriteriaTransfer->getCustomerTaskConditions()
                    ->getCustomerTaskIds(),
            );
        }

        if ($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getIsOverdue() === true) {
            $customerTaskQuery->filterByDueDate(
                ['max' => new DateTime('-1 day')],
                SprykerCriteria::BETWEEN,
            );
        }

        if ($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getTitle()) {
            $customerTaskQuery->filterByTitle(
                '%' . mb_strtolower($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getTitle()) . '%',
                Criteria::LIKE,
            );
        }

        if ($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getDescription()) {
            $customerTaskQuery->filterByDescription(
                '%' . mb_strtolower($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getDescription()) . '%',
                Criteria::LIKE,
            );
        }

        if ($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getTag()) {
            $customerTaskQuery->usePyzCustomerTaskTagRelationQuery()
                    ->usePyzCustomerTaskTagQuery()
                        ->filterByTag($customerTaskCriteriaTransfer->getCustomerTaskConditions()->getTag())
                    ->endUse()
                ->endUse();
        }

        return $customerTaskQuery;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     * @param \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery $customerTaskQuery
     *
     * @return \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery
     */
    private function applyPagination(
        CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer,
        PyzCustomerTaskQuery $customerTaskQuery,
    ): PyzCustomerTaskQuery {
        if (
            !$customerTaskCriteriaTransfer->getPagination()
            || !$customerTaskCriteriaTransfer->getPagination()->getPage()
        ) {
            return $customerTaskQuery;
        }

        $paginationTransfer = $customerTaskCriteriaTransfer->getPagination();
        if (!$paginationTransfer->getMaxPerPage()) {
            $paginationTransfer->setMaxPerPage(self::DEFAULT_PAGINATION_MAX_PER_PAGE);
        }

        $paginationModel = $customerTaskQuery->paginate(
            $paginationTransfer->getPage(),
            $paginationTransfer->getMaxPerPage(),
        );

        /** @var \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery $paginatedCustomerQuery */
        $paginatedCustomerQuery = $paginationModel->getQuery();

        return $paginatedCustomerQuery;
    }
}
