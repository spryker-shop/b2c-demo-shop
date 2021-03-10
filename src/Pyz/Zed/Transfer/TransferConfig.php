<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Transfer;

use Spryker\Zed\Transfer\TransferConfig as SprykerTransferConfig;

class TransferConfig extends SprykerTransferConfig
{
    /**
     * @return array
     */
    public function getEntitiesSourceDirectories()
    {
        return [
            APPLICATION_SOURCE_DIR . '/Orm/Propel/*/Schema/',
        ];
    }
    /**
     * Specification:
     * - When enabled, all the available transfer XML files will be checked for validity during transfer validation.
     *
     * @api
     *
     * @return bool
     */
    public function isTransferXmlValidationEnabled() : bool
    {
        return true;
    }
}
