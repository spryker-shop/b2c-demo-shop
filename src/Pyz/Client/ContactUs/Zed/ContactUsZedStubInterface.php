<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ContactUs\Zed;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsZedStubInterface
{
    public function addContactUsFeedback(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;
}
