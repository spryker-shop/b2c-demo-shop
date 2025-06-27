<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PriceProductSchedule\Communication\Console;

use Generated\Shared\Transfer\StockConditionsTransfer;
use Generated\Shared\Transfer\StockCriteriaTransfer;
use Generated\Shared\Transfer\UserConditionsTransfer;
use Generated\Shared\Transfer\UserCriteriaTransfer;
use Generated\Shared\Transfer\WarehouseUserAssignmentCollectionRequestTransfer;
use Generated\Shared\Transfer\WarehouseUserAssignmentTransfer;
use Spryker\Zed\PriceProductSchedule\Communication\Console\PriceProductScheduleApplyConsole as SprykerPriceProductScheduleApplyConsole;
use Spryker\Zed\Stock\Business\StockFacade;
use Spryker\Zed\User\Business\UserFacade;
use Spryker\Zed\WarehouseUser\Business\WarehouseUserFacade;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Spryker\Zed\PriceProductSchedule\Persistence\PriceProductScheduleRepositoryInterface getRepository()
 * @method \Spryker\Zed\PriceProductSchedule\Business\PriceProductScheduleFacadeInterface getFacade()
 */
class PriceProductScheduleApplyConsole extends SprykerPriceProductScheduleApplyConsole
{
    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // For E2E tests purpose only, should not be used in production.
        $userTransfer = (new UserFacade())->getUserCollection(
            (new UserCriteriaTransfer())->setUserConditions(
                (new UserConditionsTransfer())
                    ->addUsername('harald@spryker.com'),
            ),
        )->getUsers()->getIterator()->current();

        /** @var list<\Generated\Shared\Transfer\StockTransfer> $stockTransfers */
        $stockTransfers = (new StockFacade())->getStockCollection(
            (new StockCriteriaTransfer())->setStockConditions(
                (new StockConditionsTransfer())
                    ->addStockName('Warehouse1')
                    ->addStockName('Spryker MER000001 Warehouse 1'),
            ),
        )->getStocks()->getArrayCopy();

        $warehouseUserAssignmentCollectionRequestTransfer = (new WarehouseUserAssignmentCollectionRequestTransfer())
            ->addWarehouseUserAssignment(
                (new WarehouseUserAssignmentTransfer())
                    ->setUserUuid($userTransfer->getUuid())
                    ->setWarehouse($stockTransfers[0]),
            )
            ->addWarehouseUserAssignment(
                (new WarehouseUserAssignmentTransfer())
                    ->setUserUuid($userTransfer->getUuid())
                    ->setWarehouse($stockTransfers[1]),
            );

        (new WarehouseUserFacade())
            ->createWarehouseUserAssignmentCollection(
                $warehouseUserAssignmentCollectionRequestTransfer,
            );

        return parent::execute($input, $output);
    }
}
