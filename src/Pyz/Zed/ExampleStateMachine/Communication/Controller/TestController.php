<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ExampleStateMachine\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Spryker\Zed\StateMachine\Business\StateMachineFacade;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\ExampleStateMachine\Communication\ExampleStateMachineCommunicationFactory getFactory()
 * @method \Pyz\Zed\ExampleStateMachine\Business\ExampleStateMachineFacadeInterface getFacade()
 * @method \Pyz\Zed\ExampleStateMachine\Persistence\ExampleStateMachineQueryContainerInterface getQueryContainer()
 */
class TestController extends AbstractController
{
    /**
     * @var string
     */
    public const STATE_MACHINE_NAME = 'Test';

    /**
     * @return array<string, mixed>
     */
    public function listAction(): array
    {
        $stateMachineItems = $this->getFacade()
            ->getStateMachineItems();

        $stateMachineItems = $this->getStateMachineFacade()
            ->getProcessedStateMachineItems($stateMachineItems);

        $manualEvents = $this->getStateMachineFacade()
            ->getManualEventsForStateMachineItems($stateMachineItems);

        $exampleStateMachineItems = $this->getQueryContainer()
            ->queryAllStateMachineItems();

        return [
            'exampleStateMachineItems' => $exampleStateMachineItems,
            'manualEvents' => $manualEvents,
            'stateMachineItems' => $this->createStateMachineLookupTable($stateMachineItems),
        ];
    }

    /**
     * @param array<\Generated\Shared\Transfer\StateMachineItemTransfer> $stateMachineItems
     *
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    protected function createStateMachineLookupTable(array $stateMachineItems): array
    {
        $lookupIndex = [];
        foreach ($stateMachineItems as $stateMachineItemTransfer) {
            $lookupIndex[$stateMachineItemTransfer->getIdentifier()] = $stateMachineItemTransfer;
        }

        return $lookupIndex;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addItemAction(): RedirectResponse
    {
        $this->getFacade()->createExampleItem();

        return new RedirectResponse('/example-state-machine/test/list');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteItemAction(Request $request): RedirectResponse
    {
        $idStateMachineItem = $this->castId($request->query->get('id'));

        $this->getQueryContainer()
            ->queryExampleStateMachineItemByIdStateMachineItem($idStateMachineItem)
            ->delete();

        return new RedirectResponse('/example-state-machine/test/list');
    }

    /**
     * @return \Spryker\Zed\StateMachine\Business\StateMachineFacade
     */
    protected function getStateMachineFacade(): StateMachineFacade
    {
        return $this->getFactory()->getStateMachineFacade();
    }
}
