<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Persistence;

use Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery;
use Propel\Runtime\Collection\ObjectCollection;

interface ExampleStateMachineQueryContainerInterface
{
    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @param array<int> $stateIds
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryStateMachineItemsByStateIds(array $stateIds = []): ExampleStateMachineItemQuery;

    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryAllStateMachineItems(): ObjectCollection;

    /**
     * @psalm-suppress TooManyTemplateParams
     *
     * @param int $idStateMachineItem
     *
     * @return \Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery<\Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem>
     */
    public function queryExampleStateMachineItemByIdStateMachineItem(
        $idStateMachineItem,
    ): ExampleStateMachineItemQuery;
}
