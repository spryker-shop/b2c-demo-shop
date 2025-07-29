<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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
    public function updateItemState(StateMachineItemTransfer $stateMachineItemTransfer): bool
    {
        return $this->getFactory()->createStateMachineSaver()->updateItemState($stateMachineItemTransfer);
    }

    /**
     * @param array<int> $stateIds
     *
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getExampleStateMachineItemsByStateIds(array $stateIds = []): array
    {
        return $this->getFactory()->createExampleStateMachineItemReader()->getStateMachineItemTransferByItemStateIds($stateIds);
    }

    /**
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getStateMachineItems(): array
    {
        return $this->getFactory()->createExampleStateMachineItemReader()->getStateMachineItems();
    }

    /**
     * @return bool
     */
    public function createExampleItem(): bool
    {
        return $this->getFactory()->createStateMachineSaver()->createExampleItem();
    }
}
