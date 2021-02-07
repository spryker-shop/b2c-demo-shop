<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business\Model;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

interface ContactUsWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\PyzContactUsEntityTransfer|null $contactUsTransfer
     */
    public function save(?PyzContactUsEntityTransfer $contactUsTransfer = null);
}
