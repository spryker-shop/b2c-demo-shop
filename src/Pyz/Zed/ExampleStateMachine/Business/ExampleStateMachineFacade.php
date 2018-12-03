<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Business;

use Generated\Shared\Transfer\StateMachineItemTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Business\ExampleStateMachineBusinessFactory getFactory()
 */
class ExampleStateMachineFacade extends AbstractFacade implements ExampleStateMachineFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\StateMachineItemTransfer $stateMachineItemTransfer
     *
     * @return bool
     */
    public function itemStateUpdate(StateMachineItemTransfer $stateMachineItemTransfer)
    {
        return $this->getFactory()->createStateMachineSaver()->itemStateUpdate($stateMachineItemTransfer);
    }

    /**
     * @param int[] $stateIds
     *
     * @return \Generated\Shared\Transfer\StateMachineItemTransfer[]
     */
    public function getExampleStateMachineItemsByStateIds(array $stateIds = [])
    {
        return $this->getFactory()->createExampleStateMachineItemReader()->getStateMachineItemTransferByItemStateIds($stateIds);
    }

    /**
     * @return \Generated\Shared\Transfer\StateMachineItemTransfer[]
     */
    public function getStateMachineItems()
    {
        return $this->getFactory()->createExampleStateMachineItemReader()->getStateMachineItems();
    }

    /**
     * @return bool
     */
    public function createExampleItem()
    {
        return $this->getFactory()->createStateMachineSaver()->createExampleItem();
    }
}
