<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Customer\Persistence;

use Generated\Shared\Transfer\CustomerCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Customer\Persistence\CustomerRepository as SprykerCustomerRepository;

class CustomerRepository extends SprykerCustomerRepository
{
    /**
     * @param \Generated\Shared\Transfer\CustomerCriteriaTransfer $customerCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function findCustomerByCriteria(CustomerCriteriaTransfer $customerCriteriaTransfer): ?CustomerTransfer
    {
        $customerQuery = $this->getFactory()->createSpyCustomerQuery();
        $customerQuery= $this->applyFilters($customerQuery, $customerCriteriaTransfer);
        $customerEntity = $customerQuery->findOne();

        if ($customerEntity === null) {
            return null;
        }

        return $this->getFactory()
            ->createCustomerMapper()
            ->mapCustomerEntityToCustomer($customerEntity->toArray());
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerQuery $customerQuery
     * @param \Generated\Shared\Transfer\CustomerCriteriaTransfer $customerCriteriaTransfer
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    private function applyFilters(
        SpyCustomerQuery $customerQuery,
        CustomerCriteriaTransfer $customerCriteriaTransfer
    ): SpyCustomerQuery {
        if ($customerCriteriaTransfer->getCustomerReference()) {
            $customerQuery->filterByCustomerReference($customerCriteriaTransfer->getCustomerReference());
        }

        if ($customerCriteriaTransfer->getEmail() ) {
            $customerQuery->filterByEmail($customerCriteriaTransfer->getEmail());
        }

        return $customerQuery;
    }
}
