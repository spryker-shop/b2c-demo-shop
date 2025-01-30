<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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
