<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductStock\Hook;

use Orm\Zed\Availability\Persistence\Map\SpyAvailabilityAbstractTableMap;
use Orm\Zed\Availability\Persistence\SpyAvailabilityAbstractQuery;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Availability\Dependency\AvailabilityEvents;
use Spryker\Zed\DataImport\Business\Model\DataImporterAfterImportInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;

class ProductStockAfterImportPublishHook implements DataImporterAfterImportInterface
{
    /**
     * @var array<mixed>
     */
    protected $entityEvents = [];

    /**
     * @return void
     */
    public function afterImport(): void
    {
        $availabilities = SpyAvailabilityAbstractQuery::create()
            ->addJoin(
                SpyAvailabilityAbstractTableMap::COL_ABSTRACT_SKU,
                SpyProductAbstractTableMap::COL_SKU,
                Criteria::INNER_JOIN,
            )
            ->withColumn(SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT, 'idProductAbstract')
            ->find();

        foreach ($availabilities as $availability) {
            DataImporterPublisher::addEvent(AvailabilityEvents::AVAILABILITY_ABSTRACT_PUBLISH, $availability->getIdAvailabilityAbstract());
        }
    }
}
