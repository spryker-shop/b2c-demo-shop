<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ExampleStateMachine\Business\Model;

use Generated\Shared\Transfer\StateMachineItemTransfer;
use Orm\Zed\ExampleStateMachine\Persistence\ExampleStateMachineItem;
use Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainerInterface;

class ExampleStateMachineItemSaver
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
     * @param \Generated\Shared\Transfer\StateMachineItemTransfer $stateMachineItemTransfer
     *
     * @return bool
     */
    public function updateItemState(StateMachineItemTransfer $stateMachineItemTransfer): bool
    {
        $exampleStateMachineItemEntity = $this->exampleStateMachineQueryContainer
            ->queryExampleStateMachineItemByIdStateMachineItem($stateMachineItemTransfer->getIdentifier())
            ->findOne();

        $exampleStateMachineItemEntity->setFkStateMachineItemState($stateMachineItemTransfer->getIdItemState());
        $affectedRowCount = $exampleStateMachineItemEntity->save();

        return $affectedRowCount > 0;
    }

    /**
     * @return bool
     */
    public function createExampleItem(): bool
    {
        $exampleStateMachineItemEntity = new ExampleStateMachineItem();
        $exampleStateMachineItemEntity->setName('Test item ' . rand(123, 321));

        $affectedRowCount = $exampleStateMachineItemEntity->save();

        return $affectedRowCount > 0;
    }
}
