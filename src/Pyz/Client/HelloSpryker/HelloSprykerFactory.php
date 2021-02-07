<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\HelloSpryker;

use Pyz\Client\HelloSpryker\Zed\HelloSprykerStub;
use Spryker\Client\Kernel\AbstractFactory;

class HelloSprykerFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Client\HelloSpryker\Zed\HelloSprykerStubInterface
     */
    public function createZedHelloSprykerStub()
    {
        return new HelloSprykerStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(HelloSprykerDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
