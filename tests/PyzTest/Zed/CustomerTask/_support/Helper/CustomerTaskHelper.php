<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\CustomerTask\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\CustomerTaskBuilder;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Pyz\Zed\CustomerTask\Business\CustomerTaskFacadeInterface;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class CustomerTaskHelper extends Module
{
    use DependencyHelperTrait;
    use LocatorHelperTrait;
    use DataCleanupHelperTrait;

    /**
     * @param array<string, mixed> $override
     *
     * @return \Generated\Shared\Transfer\CustomerTaskTransfer
     */
    public function haveCustomerTask(array $override = []): CustomerTaskTransfer
    {
        $customerTaskTransfer = (new CustomerTaskBuilder($override))
            ->build();

        $customerTaskTransfer = $this->getCustomerTaskFacade()->create($customerTaskTransfer);

        $this->getDataCleanupHelper()->_addCleanup(function () use ($customerTaskTransfer): void {
            $this->debug(sprintf('Deleting Customer Task with id: %d', $customerTaskTransfer->getIdCustomerTask()));
            $this->getCustomerTaskFacade()->delete($customerTaskTransfer);
        });

        return $customerTaskTransfer;
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTaskFacadeInterface
     */
    public function getCustomerTaskFacade(): CustomerTaskFacadeInterface
    {
        return $this->getLocatorHelper()->getLocator()->customerTask()->facade();
    }
}
