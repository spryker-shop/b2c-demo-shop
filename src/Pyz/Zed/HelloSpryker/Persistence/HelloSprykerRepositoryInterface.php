<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Persistence;

interface HelloSprykerRepositoryInterface
{
    public function all();

    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer[]
     */
    public function getContactUsDataSet();
}
