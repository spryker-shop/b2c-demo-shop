<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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
    public const PYZ_STATE_MACHINE_NAME = 'Test';

    /**
     * @return array
     */
    public function listPyzAction(): array
    {
        $stateMachineItems = $this->getFacade()
            ->getPyzStateMachineItems();

        $stateMachineItems = $this->getPyzStateMachineFacade()
            ->getProcessedStateMachineItems($stateMachineItems);

        $manualEvents = $this->getPyzStateMachineFacade()
            ->getManualEventsForStateMachineItems($stateMachineItems);

        $exampleStateMachineItems = $this->getQueryContainer()
            ->queryPyzAllStateMachineItems();

        return [
            'exampleStateMachineItems' => $exampleStateMachineItems,
            'manualEvents' => $manualEvents,
            'stateMachineItems' => $this->createPyzStateMachineLookupTable($stateMachineItems),
        ];
    }

    /**
     * @param array<\Generated\Shared\Transfer\StateMachineItemTransfer> $stateMachineItems
     *
     * @return array<\Generated\Shared\Transfer\StateMachineItemTransfer>
     */
    protected function createPyzStateMachineLookupTable(array $stateMachineItems): array
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
    public function addPyzItemAction(): RedirectResponse
    {
        $this->getFacade()->createPyzExampleItem();

        return new RedirectResponse('/example-state-machine/test/list-pyz');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deletePyzItemAction(Request $request): RedirectResponse
    {
        $idStateMachineItem = $this->castId($request->query->get('id'));

        $this->getQueryContainer()
            ->queryPyzExampleStateMachineItemByIdStateMachineItem($idStateMachineItem)
            ->delete();

        return new RedirectResponse('/example-state-machine/test/list-pyz');
    }

    /**
     * @return \Spryker\Zed\StateMachine\Business\StateMachineFacade
     */
    protected function getPyzStateMachineFacade(): StateMachineFacade
    {
        return $this->getFactory()->getPyzStateMachineFacade();
    }
}
