<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business\Model;

/**
 * Class StringReader
 *
 * @package Pyz\Zed\UserHelloWorld\Business\Model
 */
interface ContactUsReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer[]
     */
    public function getContactUsData(): array;
}
