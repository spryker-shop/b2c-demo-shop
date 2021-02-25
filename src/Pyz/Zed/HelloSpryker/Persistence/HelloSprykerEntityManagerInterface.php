<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Persistence;

use Generated\Shared\Transfer\ContactUsTransfer;

interface HelloSprykerEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;
}
