<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\HelloSpryker;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface HelloSprykerClientInterface
{
    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function getContactUsData(): ContactUsTransfer;

    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsEntityTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function saveContactUsData(ContactUsTransfer $contactUsEntityTransfer): TransferInterface;
}
