<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\LeapYear\Business\Checker;

class LeapYearChecker
{
    public function checkLeapYear($year)
    {
        return ($year % 4 === 0 && ($year % 100 !== 0 || $year % 400 === 0));
    }
}
