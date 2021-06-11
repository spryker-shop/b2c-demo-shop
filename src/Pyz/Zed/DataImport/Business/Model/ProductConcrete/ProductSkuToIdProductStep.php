<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductConcrete;

use Orm\Zed\Product\Persistence\SpyProductQuery;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductSkuToIdProductStep implements DataImportStepInterface
{
    public const KEY_SOURCE = 'sku';
    public const KEY_TARGET = 'idProduct';

    /**
     * @var string
     */
    protected $source;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var array
     */
    protected static $resolved = [];

    /**
     * @param string $source
     * @param string $target
     */
    public function __construct(string $source = self::KEY_SOURCE, string $target = self::KEY_TARGET)
    {
        $this->source = $source;
        $this->target = $target;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        if (empty($dataSet[$this->source])) {
            return;
        }

        if (!isset(static::$resolved[$dataSet[$this->source]])) {
            static::$resolved[$dataSet[$this->source]] = $this->resolveIdProduct($dataSet[$this->source]);
        }

        $dataSet[$this->target] = static::$resolved[$dataSet[$this->source]];
    }

    /**
     * @param string $sku
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    protected function resolveIdProduct(string $sku): int
    {
        $query = SpyProductQuery::create();
        $productEntity = $query->findOneBySku($sku);

        if (!$productEntity) {
            throw new EntityNotFoundException(sprintf('Product with sku "%s" not found.', $sku));
        }

        return $productEntity->getIdProduct();
    }
}
