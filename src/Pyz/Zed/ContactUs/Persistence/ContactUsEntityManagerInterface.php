<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

interface ContactUsEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PyzContactUsEntityTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer|\Spryker\Shared\Kernel\Transfer\EntityTransferInterface
     */
    public function saveContactUs(PyzContactUsEntityTransfer $contactUsTransfer): PyzContactUsEntityTransfer;
}
