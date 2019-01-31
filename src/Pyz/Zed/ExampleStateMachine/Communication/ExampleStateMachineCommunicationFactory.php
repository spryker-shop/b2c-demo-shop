<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Communication;

use Pyz\Zed\ExampleStateMachine\ExampleStateMachineDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainer getQueryContainer()
 * @method \Pyz\Zed\ExampleStateMachine\Business\ExampleStateMachineFacadeInterface getFacade()
 */
class ExampleStateMachineCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Spryker\Zed\StateMachine\Business\StateMachineFacade
     */
    public function getStateMachineFacade()
    {
        return $this->getProvidedDependency(ExampleStateMachineDependencyProvider::FACADE_STATE_MACHINE);
    }
}
