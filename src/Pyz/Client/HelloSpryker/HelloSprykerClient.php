<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\HelloSpryker;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

/**
 * @method \Pyz\Client\HelloSpryker\HelloSprykerFactory getFactory()
 */
class HelloSprykerClient extends AbstractClient implements HelloSprykerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function getContactUsData(): ContactUsTransfer
    {
        return $this->getFactory()
            ->createZedHelloSprykerStub()
            ->getContactUsData();
    }

    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsEntityTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function saveContactUsData(ContactUsTransfer $contactUsEntityTransfer): TransferInterface
    {
        return $this->getFactory()
            ->createZedHelloSprykerStub()
            ->saveContactUsData($contactUsEntityTransfer);
    }
}
