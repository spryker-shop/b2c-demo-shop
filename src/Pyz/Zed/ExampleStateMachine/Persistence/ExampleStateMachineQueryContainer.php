<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Persistence;

use Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery;
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
     * @return \Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryStateMachineItemsByStateIds(array $stateIds = []): ExampleStateMachineItemQuery
    {
        return $this->getFactory()
            ->createExampleStateMachineQuery()
            ->filterByFkStateMachineItemState($stateIds, Criteria::IN);
    }

    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryAllStateMachineItems(): ObjectCollection
    {
        /** @phpstan-var \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem> */
        return $this->getFactory()
            ->createExampleStateMachineQuery()
            ->find();
    }

    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @param int $idStateMachineItem
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryExampleStateMachineItemByIdStateMachineItem(
        $idStateMachineItem,
    ): ExampleStateMachineItemQuery {
        return $this->getFactory()
            ->createExampleStateMachineQuery()
            ->filterByIdExampleStateMachineItem($idStateMachineItem);
    }
}
