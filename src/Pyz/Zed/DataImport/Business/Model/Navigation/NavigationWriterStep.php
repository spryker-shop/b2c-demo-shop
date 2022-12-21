<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\Navigation;

use Orm\Zed\Navigation\Persistence\SpyNavigation;
use Orm\Zed\Navigation\Persistence\SpyNavigationQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\Navigation\Dependency\NavigationEvents;

class NavigationWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const NAME = 'name';

    /**
     * @var string
     */
    public const KEY = 'key';

    /**
     * @var string
     */
    public const KEY_IS_ACTIVE = 'is_active';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $navigationEntity = SpyNavigationQuery::create()
            ->filterByKey($dataSet[static::KEY])
            ->findOneOrCreate();

        $navigationEntity
            ->setName($this->getName($navigationEntity, $dataSet))
            ->setIsActive((bool)$dataSet[static::KEY_IS_ACTIVE])
            ->save();

        $this->addPublishEvents(NavigationEvents::NAVIGATION_KEY_PUBLISH, $navigationEntity->getIdNavigation());
    }

    /**
     * @param \Orm\Zed\Navigation\Persistence\SpyNavigation $navigationEntity
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return string
     */
    protected function getName(SpyNavigation $navigationEntity, DataSetInterface $dataSet): string
    {
        if (isset($dataSet[static::NAME]) && !empty($dataSet[static::NAME])) {
            return $dataSet[static::NAME];
        }

        return $navigationEntity->getName();
    }
}
