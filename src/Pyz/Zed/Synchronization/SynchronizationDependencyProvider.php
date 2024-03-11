<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Synchronization;

use Spryker\Zed\AssetStorage\Communication\Plugin\Synchronization\AssetStorageSynchronizationDataPlugin;
use Spryker\Zed\AvailabilityStorage\Communication\Plugin\Synchronization\AvailabilitySynchronizationDataPlugin;
use Spryker\Zed\CategoryImageStorage\Communication\Plugin\Synchronization\CategoryImageSynchronizationDataBulkPlugin;
use Spryker\Zed\CategoryPageSearch\Communication\Plugin\Synchronization\CategoryPageSynchronizationDataBulkRepositoryPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Synchronization\CategoryNodeSynchronizationDataBulkRepositoryPlugin;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Synchronization\CategoryTreeSynchronizationDataBulkRepositoryPlugin;
use Spryker\Zed\CmsBlockCategoryStorage\Communication\Plugin\Synchronization\CmsBlockCategorySynchronizationDataPlugin;
use Spryker\Zed\CmsBlockProductStorage\Communication\Plugin\Synchronization\CmsBlockProductSynchronizationDataPlugin;
use Spryker\Zed\CmsBlockStorage\Communication\Plugin\Synchronization\CmsBlockSynchronizationDataPlugin;
use Spryker\Zed\CmsPageSearch\Communication\Plugin\Synchronization\CmsPageSynchronizationDataPlugin;
use Spryker\Zed\CmsSlotBlockStorage\Communication\Plugin\Synchronization\CmsSlotBlockSynchronizationDataBulkPlugin;
use Spryker\Zed\CmsSlotStorage\Communication\Plugin\Synchronization\CmsSlotSynchronizationDataBulkPlugin;
use Spryker\Zed\CmsStorage\Communication\Plugin\Synchronization\CmsSynchronizationDataPlugin;
use Spryker\Zed\ConfigurableBundlePageSearch\Communication\Plugin\Synchronization\ConfigurableBundleTemplatePageSynchronizationDataBulkPlugin;
use Spryker\Zed\ConfigurableBundleStorage\Communication\Plugin\Synchronization\ConfigurableBundleTemplateImageSynchronizationDataBulkPlugin;
use Spryker\Zed\ConfigurableBundleStorage\Communication\Plugin\Synchronization\ConfigurableBundleTemplateSynchronizationDataBulkPlugin;
use Spryker\Zed\ContentStorage\Communication\Plugin\Synchronization\ContentStorageSynchronizationDataPlugin;
use Spryker\Zed\CustomerAccessStorage\Communication\Plugin\Synchronization\CustomerAccessSynchronizationDataBulkPlugin;
use Spryker\Zed\CustomerStorage\Communication\Plugin\Synchronization\CustomerInvalidatedStorageSynchronizationDataPlugin;
use Spryker\Zed\FileManagerStorage\Communication\Plugin\Synchronization\FileSynchronizationDataBulkPlugin;
use Spryker\Zed\GlossaryStorage\Communication\Plugin\Synchronization\GlossarySynchronizationDataRepositoryPlugin;
use Spryker\Zed\NavigationStorage\Communication\Plugin\Synchronization\NavigationSynchronizationDataPlugin;
use Spryker\Zed\PriceProductStorage\Communication\Plugin\Synchronization\PriceProductAbstractSynchronizationDataPlugin;
use Spryker\Zed\PriceProductStorage\Communication\Plugin\Synchronization\PriceProductConcreteSynchronizationDataPlugin;
use Spryker\Zed\ProductAlternativeStorage\Communication\Plugin\Synchronization\ProductAlternativeSynchronizationDataBulkPlugin;
use Spryker\Zed\ProductAlternativeStorage\Communication\Plugin\Synchronization\ProductReplacementForSynchronizationDataBulkPlugin;
use Spryker\Zed\ProductBundleStorage\Communication\Plugin\Synchronization\ProductBundleSynchronizationDataBulkRepositoryPlugin;
use Spryker\Zed\ProductCategoryFilterStorage\Communication\Plugin\Synchronization\ProductCategoryFilterSynchronizationDataPlugin;
use Spryker\Zed\ProductCategoryStorage\Communication\Plugin\Synchronization\ProductCategorySynchronizationDataBulkRepositoryPlugin;
use Spryker\Zed\ProductConfigurationStorage\Communication\Plugin\Synchronization\ProductConfigurationSynchronizationDataRepositoryPlugin;
use Spryker\Zed\ProductDiscontinuedStorage\Communication\Plugin\Synchronization\ProductDiscontinuedSynchronizationDataBulkPlugin;
use Spryker\Zed\ProductGroupStorage\Communication\Plugin\Synchronization\ProductGroupSynchronizationDataPlugin;
use Spryker\Zed\ProductImageStorage\Communication\Plugin\Synchronization\ProductAbstractImageSynchronizationDataPlugin;
use Spryker\Zed\ProductImageStorage\Communication\Plugin\Synchronization\ProductConcreteImageSynchronizationDataPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Synchronization\ProductAbstractLabelSynchronizationDataRepositoryPlugin;
use Spryker\Zed\ProductLabelStorage\Communication\Plugin\Synchronization\ProductLabelDictionarySynchronizationDataRepositoryPlugin;
use Spryker\Zed\ProductListStorage\Communication\Plugin\Synchronization\ProductAbstractProductListSynchronizationDataBulkPlugin;
use Spryker\Zed\ProductListStorage\Communication\Plugin\Synchronization\ProductConcreteProductListSynchronizationDataBulkPlugin;
use Spryker\Zed\ProductOptionStorage\Communication\Plugin\Synchronization\ProductOptionSynchronizationDataPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Synchronization\ProductConcretePageSynchronizationDataBulkPlugin;
use Spryker\Zed\ProductPageSearch\Communication\Plugin\Synchronization\ProductPageSynchronizationDataPlugin;
use Spryker\Zed\ProductQuantityStorage\Communication\Plugin\Synchronization\ProductQuantitySynchronizationDataBulkPlugin;
use Spryker\Zed\ProductRelationStorage\Communication\Plugin\Synchronization\ProductRelationSynchronizationDataRepositoryPlugin;
use Spryker\Zed\ProductReviewSearch\Communication\Plugin\Synchronization\ProductReviewSynchronizationDataPlugin as ProductReviewSearchSynchronizationDataPlugin;
use Spryker\Zed\ProductReviewStorage\Communication\Plugin\Synchronization\ProductReviewSynchronizationDataPlugin;
use Spryker\Zed\ProductSearchConfigStorage\Communication\Plugin\Synchronization\ProductSearchConfigSynchronizationDataPlugin;
use Spryker\Zed\ProductSetPageSearch\Communication\Plugin\Synchronization\ProductSetSynchronizationDataPlugin as ProductSetSearchSynchronizationDataPlugin;
use Spryker\Zed\ProductSetStorage\Communication\Plugin\Synchronization\ProductSetSynchronizationDataPlugin;
use Spryker\Zed\ProductStorage\Communication\Plugin\Synchronization\ProductAbstractSynchronizationDataPlugin;
use Spryker\Zed\ProductStorage\Communication\Plugin\Synchronization\ProductConcreteSynchronizationDataPlugin;
use Spryker\Zed\SalesReturnSearch\Communication\Plugin\Synchronization\ReturnReasonSynchronizationDataBulkRepositoryPlugin;
use Spryker\Zed\SearchHttp\Communication\Plugin\Synchronization\SearchHttpSynchronizationDataPlugin;
use Spryker\Zed\StoreStorage\Communication\Plugin\Synchronization\StoreSynchronizationDataPlugin;
use Spryker\Zed\Synchronization\Communication\Plugin\Synchronization\SynchronizationDataQueryExpanderWhereBetweenStrategyPlugin;
use Spryker\Zed\Synchronization\SynchronizationDependencyProvider as SprykerSynchronizationDependencyProvider;
use Spryker\Zed\SynchronizationExtension\Dependency\Plugin\SynchronizationDataQueryExpanderStrategyPluginInterface;
use Spryker\Zed\TaxProductStorage\Communication\Plugin\Synchronization\TaxProductSynchronizationDataBulkRepositoryPlugin;
use Spryker\Zed\TaxStorage\Communication\Plugin\Synchronization\TaxSynchronizationDataPlugin;
use Spryker\Zed\UrlStorage\Communication\Plugin\Synchronization\UrlRedirectSynchronizationDataPlugin;
use Spryker\Zed\UrlStorage\Communication\Plugin\Synchronization\UrlSynchronizationDataPlugin;

class SynchronizationDependencyProvider extends SprykerSynchronizationDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\SynchronizationExtension\Dependency\Plugin\SynchronizationDataPluginInterface>
     */
    protected function getSynchronizationDataPlugins(): array
    {
        return [
            new CategoryPageSynchronizationDataBulkRepositoryPlugin(),
            new CmsPageSynchronizationDataPlugin(),
            new ProductPageSynchronizationDataPlugin(),
            new ProductReviewSearchSynchronizationDataPlugin(),
            new ProductSetSearchSynchronizationDataPlugin(),
            new AvailabilitySynchronizationDataPlugin(),
            new CategoryTreeSynchronizationDataBulkRepositoryPlugin(),
            new CategoryNodeSynchronizationDataBulkRepositoryPlugin(),
            new CmsBlockCategorySynchronizationDataPlugin(),
            new CmsBlockProductSynchronizationDataPlugin(),
            new StoreSynchronizationDataPlugin(),
            new CmsBlockSynchronizationDataPlugin(),
            new CmsSynchronizationDataPlugin(),
            new CmsSlotBlockSynchronizationDataBulkPlugin(),
            new CmsSlotSynchronizationDataBulkPlugin(),
            new ConfigurableBundleTemplateSynchronizationDataBulkPlugin(),
            new ConfigurableBundleTemplateImageSynchronizationDataBulkPlugin(),
            new CustomerInvalidatedStorageSynchronizationDataPlugin(),
            new FileSynchronizationDataBulkPlugin(),
            new NavigationSynchronizationDataPlugin(),
            new GlossarySynchronizationDataRepositoryPlugin(),
            new PriceProductConcreteSynchronizationDataPlugin(),
            new PriceProductAbstractSynchronizationDataPlugin(),
            new ProductCategoryFilterSynchronizationDataPlugin(),
            new ProductCategorySynchronizationDataBulkRepositoryPlugin(),
            new ProductGroupSynchronizationDataPlugin(),
            new ProductAbstractImageSynchronizationDataPlugin(),
            new ProductConcreteImageSynchronizationDataPlugin(),
            new CategoryImageSynchronizationDataBulkPlugin(),
            new ProductAbstractLabelSynchronizationDataRepositoryPlugin(),
            new ProductLabelDictionarySynchronizationDataRepositoryPlugin(),
            new ProductQuantitySynchronizationDataBulkPlugin(),
            new ProductOptionSynchronizationDataPlugin(),
            new ProductRelationSynchronizationDataRepositoryPlugin(),
            new ProductReviewSynchronizationDataPlugin(),
            new ProductSearchConfigSynchronizationDataPlugin(),
            new ProductSetSynchronizationDataPlugin(),
            new ProductConcreteSynchronizationDataPlugin(),
            new ProductAbstractSynchronizationDataPlugin(),
            new UrlRedirectSynchronizationDataPlugin(),
            new UrlSynchronizationDataPlugin(),
            new ProductAbstractProductListSynchronizationDataBulkPlugin(),
            new ProductConcreteProductListSynchronizationDataBulkPlugin(),
            new ProductDiscontinuedSynchronizationDataBulkPlugin(),
            new CustomerAccessSynchronizationDataBulkPlugin(),
            new ProductConcretePageSynchronizationDataBulkPlugin(),
            new ContentStorageSynchronizationDataPlugin(),
            new ProductAlternativeSynchronizationDataBulkPlugin(),
            new ProductReplacementForSynchronizationDataBulkPlugin(),
            new TaxProductSynchronizationDataBulkRepositoryPlugin(),
            new TaxSynchronizationDataPlugin(),
            new CmsSlotSynchronizationDataBulkPlugin(),
            new ConfigurableBundleTemplatePageSynchronizationDataBulkPlugin(),
            new ReturnReasonSynchronizationDataBulkRepositoryPlugin(),
            new ProductBundleSynchronizationDataBulkRepositoryPlugin(),
            new AssetStorageSynchronizationDataPlugin(),
            new ProductConfigurationSynchronizationDataRepositoryPlugin(),
            new SearchHttpSynchronizationDataPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\SynchronizationExtension\Dependency\Plugin\SynchronizationDataQueryExpanderStrategyPluginInterface
     */
    protected function getSynchronizationDataQueryExpanderStrategyPlugin(): SynchronizationDataQueryExpanderStrategyPluginInterface
    {
        return new SynchronizationDataQueryExpanderWhereBetweenStrategyPlugin();
    }
}
