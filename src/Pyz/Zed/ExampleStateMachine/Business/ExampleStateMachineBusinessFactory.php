<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Business;

use Pyz\Zed\ExampleStateMachine\Business\Model\ExampleStateMachineItemReader;
use Pyz\Zed\ExampleStateMachine\Business\Model\ExampleStateMachineItemSaver;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainerInterface getQueryContainer()
 */
class ExampleStateMachineBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\ExampleStateMachine\Business\Model\ExampleStateMachineItemSaver
     */
    public function createStateMachineSaver(): ExampleStateMachineItemSaver
    {
        return new ExampleStateMachineItemSaver($this->getQueryContainer());
    }

    /**
     * @return \Pyz\Zed\ExampleStateMachine\Business\Model\ExampleStateMachineItemReader
     */
    public function createExampleStateMachineItemReader(): ExampleStateMachineItemReader
    {
        return new ExampleStateMachineItemReader($this->getQueryContainer());
    }
}
