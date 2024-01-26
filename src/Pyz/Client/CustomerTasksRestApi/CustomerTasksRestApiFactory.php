<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CustomerTasksRestApi;

use Pyz\Client\CustomerTasksRestApi\Zed\CustomerTasksRestApiZedStub;
use Pyz\Client\CustomerTasksRestApi\Zed\CustomerTasksRestApiZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CustomerTasksRestApiFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Client\CustomerTasksRestApi\Zed\CustomerTasksRestApiZedStubInterface
     */
    public function createCustomerTasksRestApiZedStub(): CustomerTasksRestApiZedStubInterface
    {
        return new CustomerTasksRestApiZedStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    public function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomerTasksRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
