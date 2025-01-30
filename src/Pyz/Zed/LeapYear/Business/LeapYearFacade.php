<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\LeapYear\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\LeapYear\Business\LeapYearBusinessFactory getFactory()
 */
class LeapYearFacade extends AbstractFacade implements LeapYearFacadeInterface
{
    /**
     * Specification:
     * Converts any roman number from 1 to 3999 to integer
     *
     * @param $year
     * @return bool
     */
    public function checkLeapYear($year): bool
    {
        return $this->getFactory()->createLeapYearChecker()->checkLeapYear($year);
    }
}
