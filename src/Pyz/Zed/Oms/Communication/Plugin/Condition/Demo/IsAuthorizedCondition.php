<?php

namespace Pyz\Zed\Oms\Communication\Plugin\Condition\Demo;

use Spryker\Zed\Oms\Communication\Plugin\Oms\Condition\AbstractCondition;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

class IsAuthorizedCondition extends AbstractCondition implements ConditionInterface
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    //TODO 1: Implemente the check method and return true
    // Hint: Take a look at the `ConditionInterface`
}
