<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Persistence;

use Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainerInterface getQueryContainer()
 */
class ExampleStateMachinePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItemQuery
     */
    public function createExampleStateMachineQuery(): ExampleStateMachineItemQuery
    {
        return ExampleStateMachineItemQuery::create();
    }
}
