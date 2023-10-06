<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Business;

use Generated\Shared\Transfer\StateMachineItemTransfer;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Business\ExampleStateMachineBusinessFactory getFactory()
 */
interface ExampleStateMachineFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\StateMachineItemTransfer $stateMachineItemTransfer
     *
     * @return bool
     */
    public function updateItemState(StateMachineItemTransfer $stateMachineItemTransfer): bool;

    /**
     * @param array<int> $stateIds
     *
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getExampleStateMachineItemsByStateIds(array $stateIds = []): array;

    /**
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getStateMachineItems(): array;

    /**
     * @return bool
     */
    public function createExampleItem(): bool;
}
