<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductSearchAttribute;

use Orm\Zed\Glossary\Persistence\SpyGlossaryKeyQuery;
use Orm\Zed\Glossary\Persistence\SpyGlossaryTranslationQuery;
use Orm\Zed\ProductSearch\Persistence\SpyProductSearchAttributeQuery;
use Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep;
use Spryker\Shared\ProductSearch\Code\KeyBuilder\GlossaryKeyBuilderInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\Glossary\Dependency\GlossaryEvents;

class ProductSearchAttributeWriter extends PublishAwareStep implements DataImportStepInterface
{
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const KEY = 'key';

    /**
     * @var \Spryker\Shared\ProductSearch\Code\KeyBuilder\GlossaryKeyBuilderInterface
     */
    protected $glossaryKeyBuilder;

    /**
     * @param \Spryker\Shared\ProductSearch\Code\KeyBuilder\GlossaryKeyBuilderInterface $glossaryKeyBuilder
     */
    public function __construct(GlossaryKeyBuilderInterface $glossaryKeyBuilder)
    {
        $this->glossaryKeyBuilder = $glossaryKeyBuilder;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $productSearchAttributeEntity = SpyProductSearchAttributeQuery::create()
            ->filterByFkProductAttributeKey($dataSet[AddProductAttributeKeysStep::KEY_TARGET][$dataSet['key']])
            ->findOneOrCreate();

        $productSearchAttributeEntity
            ->setPosition($dataSet['position'])
            ->setFilterType($dataSet['filter_type'])
            ->save();

        $translationKey = $this->glossaryKeyBuilder->buildGlossaryKey($dataSet['key']);

        $glossaryKeyEntity = SpyGlossaryKeyQuery::create()
            ->filterByKey($translationKey)
            ->findOneOrCreate();

        $glossaryKeyEntity->save();

        foreach ($dataSet[ProductLocalizedAttributesExtractorStep::KEY_LOCALIZED_ATTRIBUTES] as $idLocale => $localizedAttribute) {
            if ($localizedAttribute === []) {
                continue;
            }

            $glossaryTranslationEntity = SpyGlossaryTranslationQuery::create()
                ->filterByFkLocale($idLocale)
                ->filterByFkGlossaryKey($glossaryKeyEntity->getIdGlossaryKey())
                ->findOneOrCreate();

            $glossaryTranslationEntity->setValue($localizedAttribute['key']);
            $glossaryTranslationEntity->save();

            $this->addPublishEvents(GlossaryEvents::GLOSSARY_KEY_PUBLISH, $glossaryTranslationEntity->getFkGlossaryKey());
        }
    }
}
