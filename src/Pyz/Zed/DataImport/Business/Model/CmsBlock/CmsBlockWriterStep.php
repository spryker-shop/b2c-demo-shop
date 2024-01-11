<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CmsBlock;

use Orm\Zed\CmsBlock\Persistence\SpyCmsBlock;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockGlossaryKeyMappingQuery;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockTemplate;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockTemplateQuery;
use Orm\Zed\Glossary\Persistence\SpyGlossaryKeyQuery;
use Orm\Zed\Glossary\Persistence\SpyGlossaryTranslationQuery;
use Spryker\Zed\CmsBlock\Business\Model\CmsBlockGlossaryKeyGenerator;
use Spryker\Zed\CmsBlock\Dependency\CmsBlockEvents;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\LocalizedAttributesExtractorStep;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\Glossary\Dependency\GlossaryEvents;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CmsBlockWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const KEY_BLOCK_NAME = 'block_name';

    /**
     * @var string
     */
    public const KEY_BLOCK_KEY = 'block_key';

    /**
     * @var string
     */
    public const KEY_TEMPLATE_NAME = 'template_name';

    /**
     * @var string
     */
    public const KEY_TEMPLATE_PATH = 'template_path';

    /**
     * @var string
     */
    public const KEY_ACTIVE = 'active';

    /**
     * @var string
     */
    public const KEY_PLACEHOLDER_TITLE = 'placeholder.title';

    /**
     * @var string
     */
    public const KEY_PLACEHOLDER_DESCRIPTION = 'placeholder.description';

    /**
     * @var string
     */
    public const KEY_PLACEHOLDER_CONTENT = 'placeholder.content';

    /**
     * @var string
     */
    public const KEY_PLACEHOLDER_LINK = 'placeholder.link';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $templateEntity = $this->findOrCreateCmsBlockTemplate($dataSet);
        $cmsBlockEntity = $this->findOrCreateCmsBlock($dataSet, $templateEntity);

        $this->findOrCreateCmsBlockPlaceholderTranslation($dataSet, $cmsBlockEntity);
        $this->addPublishEvents(CmsBlockEvents::CMS_BLOCK_PUBLISH, $cmsBlockEntity->getIdCmsBlock());
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return \Orm\Zed\CmsBlock\Persistence\SpyCmsBlockTemplate
     */
    protected function findOrCreateCmsBlockTemplate(DataSetInterface $dataSet): SpyCmsBlockTemplate
    {
        $templateEntity = SpyCmsBlockTemplateQuery::create()
            ->filterByTemplateName($dataSet[static::KEY_TEMPLATE_NAME])
            ->findOneOrCreate();

        $templateEntity->setTemplatePath($dataSet[static::KEY_TEMPLATE_PATH]);

        if ($templateEntity->isNew() || $templateEntity->isModified()) {
            $templateEntity->save();
        }

        return $templateEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param \Orm\Zed\CmsBlock\Persistence\SpyCmsBlockTemplate $templateEntity
     *
     * @return \Orm\Zed\CmsBlock\Persistence\SpyCmsBlock
     */
    protected function findOrCreateCmsBlock(DataSetInterface $dataSet, SpyCmsBlockTemplate $templateEntity): SpyCmsBlock
    {
        $cmsBlockEntity = SpyCmsBlockQuery::create()
            ->filterByFkTemplate($templateEntity->getIdCmsBlockTemplate())
            ->filterByKey($dataSet[static::KEY_BLOCK_KEY])
            ->filterByName($dataSet[static::KEY_BLOCK_NAME])
            ->findOneOrCreate();

        $cmsBlockEntity->setIsActive($dataSet[static::KEY_ACTIVE]);

        if ($cmsBlockEntity->isNew() || $cmsBlockEntity->isModified()) {
            $cmsBlockEntity->save();
        }

        return $cmsBlockEntity;
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param \Orm\Zed\CmsBlock\Persistence\SpyCmsBlock $cmsBlockEntity
     *
     * @return void
     */
    protected function findOrCreateCmsBlockPlaceholderTranslation(DataSetInterface $dataSet, SpyCmsBlock $cmsBlockEntity): void
    {
        foreach ($dataSet[LocalizedAttributesExtractorStep::KEY_LOCALIZED_ATTRIBUTES] as $idLocale => $placeholder) {
            foreach ($placeholder as $key => $value) {
                /** @var string $key */
                $key = str_replace('placeholder.', '', $key);
                $keyName = CmsBlockGlossaryKeyGenerator::GENERATED_GLOSSARY_KEY_PREFIX . '.';
                $keyName .= str_replace([' ', '.'], '-', $dataSet[static::KEY_TEMPLATE_NAME]) . '.';
                $keyName .= str_replace([' ', '.'], '-', $key);
                $keyName .= '.idCmsBlock.' . $cmsBlockEntity->getIdCmsBlock();
                $keyName .= '.uniqueId.1';

                $glossaryKeyEntity = SpyGlossaryKeyQuery::create()
                    ->filterByKey($keyName)
                    ->findOneOrCreate();

                if ($glossaryKeyEntity->isNew() || $glossaryKeyEntity->isModified()) {
                    $glossaryKeyEntity->save();
                }

                $glossaryTranslationEntity = SpyGlossaryTranslationQuery::create()
                    ->filterByFkGlossaryKey($glossaryKeyEntity->getIdGlossaryKey())
                    ->filterByFkLocale($idLocale)
                    ->findOneOrCreate();

                $glossaryTranslationEntity->setValue($value);

                if ($glossaryTranslationEntity->isNew() || $glossaryTranslationEntity->isModified()) {
                    $glossaryTranslationEntity->save();
                }

                $pageKeyMappingEntity = SpyCmsBlockGlossaryKeyMappingQuery::create()
                    ->filterByFkGlossaryKey($glossaryKeyEntity->getIdGlossaryKey())
                    ->filterByFkCmsBlock($cmsBlockEntity->getIdCmsBlock())
                    ->findOneOrCreate();

                $pageKeyMappingEntity->setPlaceholder($key);

                if ($pageKeyMappingEntity->isNew() || $pageKeyMappingEntity->isModified()) {
                    $pageKeyMappingEntity->save();
                }

                $this->addPublishEvents(GlossaryEvents::GLOSSARY_KEY_PUBLISH, $glossaryTranslationEntity->getFkGlossaryKey());
            }
        }
    }
}
