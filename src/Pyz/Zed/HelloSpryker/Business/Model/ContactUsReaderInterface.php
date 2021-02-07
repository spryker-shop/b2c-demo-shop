<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business\Model;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

/**
 * Class StringReader
 *
 * @package Pyz\Zed\UserHelloWorld\Business\Model
 */
interface ContactUsReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer
     */
    public function getContactUsData(): PyzContactUsEntityTransfer;
}
