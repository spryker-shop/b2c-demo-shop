<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\Locale;

use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class LocaleNameToIdLocaleStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const KEY_SOURCE = 'localeName';

    /**
     * @var string
     */
    public const KEY_TARGET = 'idLocale';

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var array<string, int>
     */
    protected $resolved = [];

    /**
     * @param string $source
     * @param string $target
     */
    public function __construct($source = self::KEY_SOURCE, $target = self::KEY_TARGET)
    {
        $this->source = $source;
        $this->target = $target;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        if (!isset($dataSet[$this->source])) {
            throw new DataKeyNotFoundInDataSetException(sprintf(
                'Expected a key "%s" in current data set. Available keys: "%s"',
                $this->source,
                implode(', ', array_keys($dataSet->getArrayCopy())),
            ));
        }

        /** @var string $localeName */
        $localeName = $dataSet[$this->source];
        if (!isset($this->resolved[$localeName])) {
            $this->resolved[$localeName] = $this->resolveIdLocale($localeName);
        }

        $dataSet[$this->target] = $this->resolved[$localeName];
    }

    /**
     * @param string $localeName
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    protected function resolveIdLocale($localeName): int
    {
        $query = SpyLocaleQuery::create();
        $localeEntity = $query->filterByLocaleName($localeName)->findOne();

        if (!$localeEntity) {
            throw new EntityNotFoundException(sprintf('Locale by name "%s" not found.', $localeName));
        }

        $localeEntity->save();

        return $localeEntity->getIdLocale();
    }
}
