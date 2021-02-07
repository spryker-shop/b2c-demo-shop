<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

interface HelloSprykerFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer
     */
    public function getContactUsData();

    /**
     * @param \Generated\Shared\Transfer\PyzContactUsEntityTransfer $contactUsEntityTransfer
     *
     * @return void
     */
    public function saveContactUsData(PyzContactUsEntityTransfer $contactUsEntityTransfer);
}
