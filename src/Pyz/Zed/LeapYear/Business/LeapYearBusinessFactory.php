<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\LeapYear\Business;

use Pyz\Zed\LeapYear\Business\Checker\LeapYearChecker;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\LeapYear\LeapYearConfig getConfig()
 */
class LeapYearBusinessFactory extends AbstractBusinessFactory
{
    public function createLeapYearChecker()
    {
        return new LeapYearChecker();
    }
}
