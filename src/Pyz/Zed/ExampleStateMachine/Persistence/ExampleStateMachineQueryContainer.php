<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Persistence;

use Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItemQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachinePersistenceFactory getFactory()
 */
class ExampleStateMachineQueryContainer extends AbstractQueryContainer implements ExampleStateMachineQueryContainerInterface
{
    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @param array<int> $stateIds
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItemQuery<\Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem>
     */
    public function queryPyzStateMachineItemsByStateIds(array $stateIds = []): PyzExampleStateMachineItemQuery
    {
          return $this->getFactory()
              ->createPyzExampleStateMachineQuery()
              ->filterByFkStateMachineItemState($stateIds, Criteria::IN);
    }

    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem>
     */
    public function queryPyzAllStateMachineItems(): ObjectCollection
    {
         return $this->getFactory()
             ->createPyzExampleStateMachineQuery()
             ->find();
    }

    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @param int $idStateMachineItem
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItemQuery<\Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem>
     */
    public function queryPyzExampleStateMachineItemByIdStateMachineItem(
        $idStateMachineItem,
    ): PyzExampleStateMachineItemQuery {
        return $this->getFactory()
            ->createPyzExampleStateMachineQuery()
            ->filterByIdExampleStateMachineItem($idStateMachineItem);
    }
}
