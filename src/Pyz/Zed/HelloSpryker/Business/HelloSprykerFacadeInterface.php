<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business;

use Generated\Shared\Transfer\ContactUsTransfer;

interface HelloSprykerFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer[]
     */
    public function getContactUsData(): array;

    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsEntityTransfer
     *
     * @return void
     */
    public function saveContactUsData(ContactUsTransfer $contactUsEntityTransfer);
}
