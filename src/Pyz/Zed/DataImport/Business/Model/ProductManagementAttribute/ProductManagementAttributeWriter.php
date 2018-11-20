<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute;

use Orm\Zed\Glossary\Persistence\SpyGlossaryKeyQuery;
use Orm\Zed\Glossary\Persistence\SpyGlossaryTranslationQuery;
use Orm\Zed\ProductAttribute\Persistence\SpyProductManagementAttributeQuery;
use Orm\Zed\ProductAttribute\Persistence\SpyProductManagementAttributeValueQuery;
use Orm\Zed\ProductAttribute\Persistence\SpyProductManagementAttributeValueTranslation;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep;
use Spryker\Shared\ProductAttribute\ProductAttributeConfig;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\Glossary\Dependency\GlossaryEvents;

class ProductManagementAttributeWriter extends PublishAwareStep implements DataImportStepInterface
{
    public const BULK_SIZE = 100;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet)
    {
        $productManagementAttributeEntity = SpyProductManagementAttributeQuery::create()
            ->filterByFkProductAttributeKey($dataSet[AddProductAttributeKeysStep::KEY_TARGET][$dataSet['key']])
            ->findOneOrCreate();

        $productManagementAttributeEntity
            ->setAllowInput($dataSet['allow_input'])
            ->setInputType($dataSet['input_type']);

        $productManagementAttributeEntity->save();

        $productManagementAttributeValueEntityCollection = SpyProductManagementAttributeValueQuery::create()
            ->findByFkProductManagementAttribute($productManagementAttributeEntity->getIdProductManagementAttribute());

        foreach ($productManagementAttributeValueEntityCollection as $productManagementAttributeValueEntity) {
            foreach ($productManagementAttributeValueEntity->getSpyProductManagementAttributeValueTranslations() as $productManagementAttributeValueTranslation) {
                $productManagementAttributeValueTranslation->delete();
            }

            $productManagementAttributeValueEntity->delete();
        }

        $glossaryKey = ProductAttributeConfig::PRODUCT_ATTRIBUTE_GLOSSARY_PREFIX . $dataSet['key'];
        $glossaryKeyEntity = SpyGlossaryKeyQuery::create()
            ->filterByKey($glossaryKey)
            ->findOneOrCreate();

        $glossaryKeyEntity->save();

        foreach ($dataSet[ProductManagementLocalizedAttributesExtractorStep::KEY_LOCALIZED_ATTRIBUTES] as $idLocale => $attributes) {
            $glossaryTranslationEntity = SpyGlossaryTranslationQuery::create()
                ->filterByFkGlossaryKey($glossaryKeyEntity->getIdGlossaryKey())
                ->filterByFkLocale($idLocale)
                ->findOneOrCreate();

            $glossaryTranslationEntity
                ->setValue($attributes['key_translation'])
                ->save();

            $this->addPublishEvents(GlossaryEvents::GLOSSARY_KEY_PUBLISH, $glossaryTranslationEntity->getFkGlossaryKey());

            if (!empty($attributes['value_translations'])) {
                foreach ($attributes['value_translations'] as $value => $translation) {
                    $productManagementAttributeValueEntity = SpyProductManagementAttributeValueQuery::create()
                        ->filterBySpyProductManagementAttribute($productManagementAttributeEntity)
                        ->filterByValue($value)
                        ->findOneOrCreate();

                    $productManagementAttributeValueEntity->save();

                    $productManagementAttributeValueTranslationEntity = new SpyProductManagementAttributeValueTranslation();
                    $productManagementAttributeValueTranslationEntity
                        ->setSpyProductManagementAttributeValue($productManagementAttributeValueEntity)
                        ->setTranslation($translation)
                        ->setFkLocale($idLocale)
                        ->save();
                }

                continue;
            }

            foreach ($attributes['values'] as $value) {
                $productManagementAttributeValueEntity = SpyProductManagementAttributeValueQuery::create()
                    ->filterBySpyProductManagementAttribute($productManagementAttributeEntity)
                    ->filterByValue($value)
                    ->findOneOrCreate();

                $productManagementAttributeValueEntity->save();
            }
        }
    }
}
