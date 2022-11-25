<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\Country\Repository;

interface CountryRepositoryInterface
{
    /**
     * @param string $countryName
     *
     * @return bool
     */
    public function hasCountryByName($countryName): bool;

    /**
     * @param string $countryName
     *
     * @return int
     */
    public function getIdCountryByName($countryName): int;
}
