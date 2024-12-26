<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductStorage\Communication\Plugin\Event\Listener;

use Orm\Zed\ProductBundle\Persistence\Map\SpyProductBundleTableMap;
use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \Pyz\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductStorage\Communication\ProductStorageCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductStorage\Business\ProductStorageFacadeInterface getFacade()
 * @method \Pyz\Zed\ProductStorage\ProductStorageConfig getConfig()
 */
class ProductBundleStoragePublishListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use DatabaseTransactionHandlerTrait;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName): void // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter
    {
        $this->preventTransaction();
        $productIds = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransferForeignKeys($eventTransfers, SpyProductBundleTableMap::COL_FK_PRODUCT);

        $this->getFacade()->publishConcreteProducts($productIds);
    }
}
