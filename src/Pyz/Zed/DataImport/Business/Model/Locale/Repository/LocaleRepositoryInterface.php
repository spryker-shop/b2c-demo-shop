<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\Locale\Repository;

interface LocaleRepositoryInterface
{
    /**
     * @param string $locale
     *
     * @return int
     */
    public function getIdLocaleByLocale(string $locale): int;
}
