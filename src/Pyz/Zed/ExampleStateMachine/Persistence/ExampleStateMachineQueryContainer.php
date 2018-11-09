<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Persistence;

use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachinePersistenceFactory getFactory()
 */
class ExampleStateMachineQueryContainer extends AbstractQueryContainer implements ExampleStateMachineQueryContainerInterface
{
    /**
     * @param int[] $stateIds
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItemQuery
     */
    public function queryStateMachineItemsByStateIds(array $stateIds = [])
    {
          return $this->getFactory()
              ->createExampleStateMachineQuery()
              ->filterByFkStateMachineItemState($stateIds, Criteria::IN);
    }

    /**
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function queryAllStateMachineItems()
    {
         return $this->getFactory()
             ->createExampleStateMachineQuery()
             ->find();
    }

    /**
     * @param int $idStateMachineItem
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem[]|\Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItemQuery|\Propel\Runtime\Collection\ObjectCollection
     */
    public function queryExampleStateMachineItemByIdStateMachineItem($idStateMachineItem)
    {
        return $this->getFactory()
            ->createExampleStateMachineQuery()
            ->filterByIdExampleStateMachineItem($idStateMachineItem);
    }
}
