<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\HelloSpryker;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\HelloSpryker\HelloSprykerFactory getFactory()
 */
class HelloSprykerClient extends AbstractClient implements HelloSprykerClientInterface
{
    /**
     * @return \Pyz\Client\HelloSpryker\Zed\HelloSprykerStubInterface
     */
    protected function getZedStub()
    {
        return $this->getFactory()->createZedHelloSprykerStub();
    }

    /**
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer
     */
    public function getContactUsData()
    {
        return $this->getFactory()
            ->createZedHelloSprykerStub()
            ->getContactUsData();
    }

    public function saveContactUsData(PyzContactUsEntityTransfer $contactUsEntityTransfer)
    {
        return $this->getFactory()
            ->createZedHelloSprykerStub()
            ->saveContactUsData($contactUsEntityTransfer);
    }
}
