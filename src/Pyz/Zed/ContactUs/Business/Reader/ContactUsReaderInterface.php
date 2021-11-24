<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Business\Reader;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer[]
     */
    public function getContactUsMessages(): array;

    /**
     * @param int $contactUsId
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer|null
     */
    public function findContactUsById(int $contactUsId): ?ContactUsTransfer;
}
