<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleStateMachine\Business\Model;

use Generated\Shared\Transfer\StateMachineItemTransfer;
use Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainerInterface;

class ExampleStateMachineItemReader
{
    /**
     * @var \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainerInterface
     */
    protected $exampleStateMachineQueryContainer;

    /**
     * @param \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainerInterface $exampleStateMachineQueryContainer
     */
    public function __construct(ExampleStateMachineQueryContainerInterface $exampleStateMachineQueryContainer)
    {
        $this->exampleStateMachineQueryContainer = $exampleStateMachineQueryContainer;
    }

    /**
     * @param array<int> $stateIds
     *
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getStateMachineItemTransferByItemStateIds(array $stateIds = []): array
    {
        $exampleStateMachineItems = $this->exampleStateMachineQueryContainer
            ->queryPyzStateMachineItemsByStateIds($stateIds)
            ->find();

        return $this->hydrateTransferFromPersistence($exampleStateMachineItems);
    }

    /**
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    public function getStateMachineItems(): array
    {
        $exampleStateMachineItems = $this->exampleStateMachineQueryContainer
            ->queryPyzAllStateMachineItems();

        return $this->hydrateTransferFromPersistence($exampleStateMachineItems);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ExampleStateMachine\Persistence\PyzExampleStateMachineItem> $exampleStateMachineItems
     *
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    protected function hydrateTransferFromPersistence($exampleStateMachineItems): array
    {
        $stateMachineItems = [];
        foreach ($exampleStateMachineItems as $exampleStateMachineItemEntity) {
            if (!$exampleStateMachineItemEntity->getFkStateMachineItemState()) {
                continue;
            }

            $stateMachineItemIdentifier = new StateMachineItemTransfer();
            $stateMachineItemIdentifier->setIdentifier($exampleStateMachineItemEntity->getIdExampleStateMachineItem());
            $stateMachineItemIdentifier->setIdItemState($exampleStateMachineItemEntity->getFkStateMachineItemState());

            $stateMachineItems[] = $stateMachineItemIdentifier;
        }

        return $stateMachineItems;
    }
}
