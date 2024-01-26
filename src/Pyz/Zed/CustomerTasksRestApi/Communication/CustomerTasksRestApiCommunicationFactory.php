<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTasksRestApi\Communication;

use Pyz\Zed\CustomerTask\Business\CustomerTaskFacadeInterface;
use Pyz\Zed\CustomerTasksRestApi\CustomerTasksRestApiDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CustomerTasksRestApiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTaskFacadeInterface
     */
    public function getCustomerTaskFacade(): CustomerTaskFacadeInterface
    {
        return $this->getProvidedDependency(CustomerTasksRestApiDependencyProvider::FACADE_CUSTOMER_TASK);
    }
}
