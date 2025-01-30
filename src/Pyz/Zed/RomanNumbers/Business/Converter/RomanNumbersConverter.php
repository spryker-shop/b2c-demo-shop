<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\RomanNumbers\Business\Converter;

use function PHPUnit\Framework\throwException;
use Pyz\Zed\RomanNumbers\Business\Exception\NotARomanNumberException;
class RomanNumbersConverter
{
    private const NUMBERS = [
    'I' => 1,
    'V' => 5,
    'X' => 10,
    'L' => 50,
    'C' => 100,
    'D' => 500,
    'M' => 1000,
    ];

    /**
     * @param string $romanNumbers
     * @return int
     * @throws NotARomanNumberException
     */
    public function convert(string $romanNumbers): int
    {
        if (!$this->isValidRomanNumber($romanNumbers)) {
            throw new NotARomanNumberException($romanNumbers);
        }

        $romanNumbers = str_replace('IV', 'IIII', $romanNumbers);
        $romanNumbers = str_replace('IX', 'VIIII', $romanNumbers);
        $romanNumbers = str_replace('XL', 'XXXX', $romanNumbers);
        $romanNumbers = str_replace('XC', 'LXXXX', $romanNumbers);
        $romanNumbers = str_replace('CD', 'CCCC', $romanNumbers);
        $romanNumbers = str_replace('CM', 'DCCCC', $romanNumbers);
        $romanNumbers = str_replace('XD', 'CCCCLXXXX', $romanNumbers);

        $result = 0;
        $result += substr_count($romanNumbers, 'I');
        $result += substr_count($romanNumbers, 'V') * 5;
        $result += substr_count($romanNumbers, 'X') * 10;
        $result += substr_count($romanNumbers, 'L') * 50;
        $result += substr_count($romanNumbers, 'C') * 100;
        $result += substr_count($romanNumbers, 'D') * 500;
        $result += substr_count($romanNumbers, 'M') * 1000;

        return $result;
    }

    /**
     * @param string $romanNumbers
     * @return bool
     */
    private function isValidRomanNumber(string $romanNumbers): bool
    {
        if (empty($romanNumbers)) {
            return false;
        }
        $split_romanNumbers = str_split($romanNumbers);
        foreach ($split_romanNumbers as $romanNumber) {
            $validcharacters = ["I", "V", "X", "L", "C", "D", "M"];
            if (!in_array($romanNumber, $validcharacters)) {
                return false;
            }
        }
        return true;
    }
}


