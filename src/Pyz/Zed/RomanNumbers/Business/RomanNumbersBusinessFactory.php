<?php

declare(strict_types = 1);

namespace Pyz\Zed\RomanNumbers\Business;

use Pyz\Zed\RomanNumbers\Business\Converter\RomanNumbersConverter;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\RomanNumbers\RomanNumbersConfig getConfig()
 */
class RomanNumbersBusinessFactory extends AbstractBusinessFactory
{
    public function createRomanNumbersConverter()
    {
        return new RomanNumbersConverter();
    }
}
