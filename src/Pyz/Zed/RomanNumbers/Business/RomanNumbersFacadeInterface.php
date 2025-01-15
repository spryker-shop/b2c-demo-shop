<?php

declare(strict_types = 1);

namespace Pyz\Zed\RomanNumbers\Business;

interface RomanNumbersFacadeInterface
{
    public function convertRomanToInteger(string $romanNumber): int;
}
