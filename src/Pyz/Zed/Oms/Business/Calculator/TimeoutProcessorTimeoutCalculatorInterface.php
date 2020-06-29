<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Oms\Business\Calculator;

use Generated\Shared\Transfer\TimeoutProcessorTimeoutRequestTransfer;
use Generated\Shared\Transfer\TimeoutProcessorTimeoutResponseTransfer;

interface TimeoutProcessorTimeoutCalculatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\TimeoutProcessorTimeoutRequestTransfer $timeoutProcessorTimeoutRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TimeoutProcessorTimeoutResponseTransfer
     */
    public function calculateTimeout(TimeoutProcessorTimeoutRequestTransfer $timeoutProcessorTimeoutRequestTransfer): TimeoutProcessorTimeoutResponseTransfer;
}
