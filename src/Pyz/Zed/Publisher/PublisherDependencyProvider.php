<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Publisher;

use Spryker\Shared\GlossaryStorage\GlossaryStorageConfig;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryKey\GlossaryDeletePublisherPlugin as GlossaryKeyDeletePublisherPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryKey\GlossaryWritePublisherPlugin as GlossaryKeyWriterPublisherPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryPublisherTriggerPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Publisher\GlossaryTranslation\GlossaryWritePublisherPlugin as GlossaryTranslationWritePublisherPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabel\ProductLabelWritePublisherPlugin as ProductLabelSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabelProductAbstract\ProductLabelProductAbstractWritePublisherPlugin as ProductLabelProductAbstractSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelSearch\Communication\Plugin\Publisher\ProductLabelStore\ProductLabelStoreWritePublisherPlugin as ProductLabelStoreSearchWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductAbstractLabel\ProductAbstractLabelWritePublisherPlugin as ProductAbstractLabelStorageWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductAbstractLabelPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionary\ProductLabelDictionaryDeletePublisherPlugin as ProductLabelDictionaryStorageDeletePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionary\ProductLabelDictionaryWritePublisherPlugin as ProductLabelDictionaryStorageWritePublisherPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelDictionaryPublisherTriggerPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Publisher\ProductLabelProductAbstract\ProductLabelProductAbstractWritePublisherPlugin as ProductLabelProductAbstractStorageWritePublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelation\ProductRelationWriteForPublishingPublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelation\ProductRelationWritePublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationProductAbstract\ProductRelationProductAbstractWritePublisherPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationPublisherTriggerPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Publisher\ProductRelationStore\ProductRelationStoreWritePublisherPlugin;
use Spryker\Zed\Publisher\PublisherDependencyProvider as SprykerPublisherDependencyProvider;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReason\ReturnReasonDeletePublisherPlugin;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReason\ReturnReasonWritePublisherPlugin;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Publisher\ReturnReasonPublisherTriggerPlugin;

class PublisherDependencyProvider extends SprykerPublisherDependencyProvider
{
    /**
     * @return \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface[]
     */
    protected function getPublisherPlugins(): array
    {
        return array_merge(
            $this->getGlossaryStoragePlugins(),
            $this->getProductRelationStoragePlugins(),
            $this->getProductLabelStoragePlugins(),
            $this->getProductLabelSearchPlugins(),
            $this->getReturnReasonSearchPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherTriggerPluginInterface[]
     */
    protected function getPublisherTriggerPlugins(): array
    {
        return [
            new GlossaryPublisherTriggerPlugin(),
            new ProductRelationPublisherTriggerPlugin(),
            new ProductAbstractLabelPublisherTriggerPlugin(),
            new ProductLabelDictionaryPublisherTriggerPlugin(),
            new ReturnReasonPublisherTriggerPlugin(),
        ];
    }

    /**
     * @return array
     */
    protected function getGlossaryStoragePlugins(): array
    {
        return [
            GlossaryStorageConfig::PUBLISH_TRANSLATION => [
                new GlossaryKeyDeletePublisherPlugin(),
                new GlossaryKeyWriterPublisherPlugin(),
                new GlossaryTranslationWritePublisherPlugin(),
            ],
        ];
    }

    /**
     * @return \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface[]
     */
    protected function getProductRelationStoragePlugins(): array
    {
        return [
            new ProductRelationWritePublisherPlugin(),
            new ProductRelationWriteForPublishingPublisherPlugin(),
            new ProductRelationProductAbstractWritePublisherPlugin(),
            new ProductRelationStoreWritePublisherPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface[]
     */
    protected function getProductLabelStoragePlugins(): array
    {
        return [
            new ProductAbstractLabelStorageWritePublisherPlugin(),
            new ProductLabelProductAbstractStorageWritePublisherPlugin(),
            new ProductLabelDictionaryStorageWritePublisherPlugin(),
            new ProductLabelDictionaryStorageDeletePublisherPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface[]
     */
    protected function getProductLabelSearchPlugins(): array
    {
        return [
            new ProductLabelSearchWritePublisherPlugin(),
            new ProductLabelProductAbstractSearchWritePublisherPlugin(),
            new ProductLabelStoreSearchWritePublisherPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface[]
     */
    protected function getReturnReasonSearchPlugins(): array
    {
        return [
            new ReturnReasonWritePublisherPlugin(),
            new ReturnReasonDeletePublisherPlugin(),
        ];
    }
}
