<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Persistence;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

interface HelloSprykerEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\PyzContactUsEntityTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer
     */
    public function saveContactUsData(PyzContactUsEntityTransfer $contactUsTransfer): PyzContactUsEntityTransfer;
}
