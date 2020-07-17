<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Business;

use Pyz\Zed\Oms\Business\Calculator\InitiationTimeoutCalculator;
use Pyz\Zed\Oms\Business\Calculator\TimeoutProcessorTimeoutCalculatorInterface;
use Spryker\Zed\Oms\Business\OmsBusinessFactory as SprykerOmsBusinessFactory;

class OmsBusinessFactory extends SprykerOmsBusinessFactory
{
    /**
     * @return \Pyz\Zed\Oms\Business\Calculator\TimeoutProcessorTimeoutCalculatorInterface
     */
    public function createInitiationTimeoutCalculator(): TimeoutProcessorTimeoutCalculatorInterface
    {
        return new InitiationTimeoutCalculator();
    }
}
