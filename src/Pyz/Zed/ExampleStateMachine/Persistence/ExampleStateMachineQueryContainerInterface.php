<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Persistence;

interface ExampleStateMachineQueryContainerInterface
{
    /**
     * @param int[] $stateIds
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItemQuery
     */
    public function queryStateMachineItemsByStateIds(array $stateIds = []);

    /**
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem[]|\Propel\Runtime\Collection\ObjectCollection
     */
    public function queryAllStateMachineItems();

    /**
     * @param int $idStateMachineItem
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem[]|\Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItemQuery|\Propel\Runtime\Collection\ObjectCollection
     */
    public function queryExampleStateMachineItemByIdStateMachineItem($idStateMachineItem);
}
