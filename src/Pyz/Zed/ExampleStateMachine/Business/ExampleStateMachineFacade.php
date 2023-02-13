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
    public function updatePyzItemState(StateMachineItemTransfer $stateMachineItemTransfer): bool
    {
        return $this->getFactory()->createPyzStateMachineSaver()->updateItemState($stateMachineItemTransfer);
    }

    /**
     * @param array<int> $stateIds
     *
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getPyzExampleStateMachineItemsByStateIds(array $stateIds = []): array
    {
        return $this->getFactory()->createPyzExampleStateMachineItemReader()->getStateMachineItemTransferByItemStateIds($stateIds);
    }

    /**
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getPyzStateMachineItems(): array
    {
        return $this->getFactory()->createPyzExampleStateMachineItemReader()->getStateMachineItems();
    }

    /**
     * @return bool
     */
    public function createPyzExampleItem(): bool
    {
        return $this->getFactory()->createPyzStateMachineSaver()->createExampleItem();
    }
}
