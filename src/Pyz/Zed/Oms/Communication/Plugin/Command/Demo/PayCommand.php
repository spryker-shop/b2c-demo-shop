<?php

namespace Pyz\Zed\Oms\Communication\Plugin\Command\Demo;

use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\AbstractCommand;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

class PayCommand extends AbstractCommand implements CommandByOrderInterface
{
    /**
     *
     * Command which is executed per order basis
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array
     * @api
     *
     */
    // TODO 1
    // Implement the `run()` method of the `CommandByOrderInterface` interface
    // and just return an empty array
}
