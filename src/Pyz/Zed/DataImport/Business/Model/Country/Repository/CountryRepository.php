<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\Country\Repository;

use ArrayObject;
use Orm\Zed\Country\Persistence\SpyCountryQuery;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * @var \ArrayObject<string, int>
     */
    protected $countryIds;

    public function __construct()
    {
        $this->countryIds = new ArrayObject();
    }

    /**
     * @param string $countryName
     *
     * @return bool
     */
    public function hasCountryByName(string $countryName): bool
    {
        if ($this->countryIds->count() === 0) {
            $this->loadCountries();
        }

        return isset($this->countryIds[$countryName]);
    }

    /**
     * @param string $countryName
     *
     * @return int
     */
    public function getIdCountryByName(string $countryName): int
    {
        if ($this->countryIds->count() === 0) {
            $this->loadCountries();
        }

        return $this->countryIds[$countryName];
    }

    /**
     * @return void
     */
    private function loadCountries(): void
    {
        $query = SpyCountryQuery::create();

        foreach ($query->find() as $countryEntity) {
            $this->countryIds[$countryEntity->getName()] = $countryEntity->getIdCountry();
        }
    }
}
