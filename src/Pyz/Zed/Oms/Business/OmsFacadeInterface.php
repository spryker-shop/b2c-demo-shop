<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Business;

use Generated\Shared\Transfer\TimeoutProcessorTimeoutRequestTransfer;
use Generated\Shared\Transfer\TimeoutProcessorTimeoutResponseTransfer;
use Spryker\Zed\Oms\Business\OmsFacadeInterface as SprykerOmsFacadeInterface;

interface OmsFacadeInterface extends SprykerOmsFacadeInterface
{
    /**
     * Specification:
     * - Calculates the timeout based on the current time + the defined timeout.
     * - Returns `TimeoutProcessorTimeoutRequestTransfer` with timestamp when event should be triggered.
     * - Dummy implementation for presenting TimeoutProcessor behavior.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TimeoutProcessorTimeoutRequestTransfer $timeoutProcessorTimeoutRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TimeoutProcessorTimeoutResponseTransfer
     */
    public function calculatePyzInitiationTimeout(
        TimeoutProcessorTimeoutRequestTransfer $timeoutProcessorTimeoutRequestTransfer
    ): TimeoutProcessorTimeoutResponseTransfer;
}
