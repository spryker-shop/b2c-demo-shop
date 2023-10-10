<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Communication\Plugin\Oms;

use Generated\Shared\Transfer\OmsEventTransfer;
use Generated\Shared\Transfer\TimeoutProcessorTimeoutRequestTransfer;
use Generated\Shared\Transfer\TimeoutProcessorTimeoutResponseTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\OmsExtension\Dependency\Plugin\TimeoutProcessorPluginInterface;

/**
 * @method \Pyz\Zed\Oms\Business\OmsFacadeInterface getFacade()
 * @method \Pyz\Zed\Oms\Communication\OmsCommunicationFactory getFactory()
 * @method \Pyz\Zed\Oms\OmsConfig getConfig()
 * @method \Spryker\Zed\Oms\Persistence\OmsQueryContainerInterface getQueryContainer()
 */
class InitiationTimeoutProcessorPlugin extends AbstractPlugin implements TimeoutProcessorPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return 'OmsTimeout/Initiation';
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OmsEventTransfer $omsEventTransfer
     *
     * @return string
     */
    public function getLabel(OmsEventTransfer $omsEventTransfer): string
    {
        return sprintf(
            $this->getFactory()->getTranslatorFacade()->trans('Starts when defined timeout (%s) is over.'),
            $omsEventTransfer->getTimeout(),
        );
    }

    /**
     * {@inheritDoc}
     * - Calculates the timeout based on the current time + the defined timeout.
     * - Returns `TimeoutProcessorTimeoutRequestTransfer` with timestamp when event should be triggered.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TimeoutProcessorTimeoutRequestTransfer $timeoutProcessorTimeoutRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TimeoutProcessorTimeoutResponseTransfer
     */
    public function calculateTimeout(TimeoutProcessorTimeoutRequestTransfer $timeoutProcessorTimeoutRequestTransfer): TimeoutProcessorTimeoutResponseTransfer
    {
        return $this->getFacade()->calculateInitiationTimeout($timeoutProcessorTimeoutRequestTransfer);
    }
}
