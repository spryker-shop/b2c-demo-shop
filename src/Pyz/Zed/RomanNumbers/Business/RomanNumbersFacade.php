<?php

declare(strict_types = 1);

namespace Pyz\Zed\RomanNumbers\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\RomanNumbers\Business\RomanNumbersBusinessFactory getFactory()
 */
class RomanNumbersFacade extends AbstractFacade implements RomanNumbersFacadeInterface
{
    /**
     * Specification:
     * Converts any roman number from 1 to 3999 to integer
     * @param string $romanNumbers
     *
     * @return int
     */
    public function convertRomanToInteger(string $romanNumber): int
    {
        return $this->getFactory()->createRomanNumbersConverter()->convert($romanNumber);
    }
}
