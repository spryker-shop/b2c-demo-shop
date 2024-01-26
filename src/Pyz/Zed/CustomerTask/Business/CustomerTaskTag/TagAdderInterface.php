<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\CustomerTaskTag;

use Generated\Shared\Transfer\CustomerTaskTransfer;

interface TagAdderInterface
{
    /**
     * @param string $tag
     * @param int $idCustomerTask
     *
     * @throws \Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function addTag(string $tag, int $idCustomerTask): CustomerTaskTransfer;
}
