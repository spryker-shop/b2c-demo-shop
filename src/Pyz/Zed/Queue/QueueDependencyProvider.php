<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Queue;

use Spryker\Shared\AvailabilityStorage\AvailabilityStorageConstants;
use Spryker\Shared\CategoryPageSearch\CategoryPageSearchConstants;
use Spryker\Shared\CategoryStorage\CategoryStorageConstants;
use Spryker\Shared\CmsPageSearch\CmsPageSearchConstants;
use Spryker\Shared\CmsStorage\CmsStorageConstants;
use Spryker\Shared\Config\Config;
use Spryker\Shared\ConfigurableBundlePageSearch\ConfigurableBundlePageSearchConfig;
use Spryker\Shared\ConfigurableBundleStorage\ConfigurableBundleStorageConfig;
use Spryker\Shared\ContentStorage\ContentStorageConfig;
use Spryker\Shared\CustomerAccessStorage\CustomerAccessStorageConstants;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\FileManagerStorage\FileManagerStorageConstants;
use Spryker\Shared\GlossaryStorage\GlossaryStorageConfig;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\PriceProductStorage\PriceProductStorageConstants;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConstants;
use Spryker\Shared\ProductStorage\ProductStorageConstants;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Shared\SalesReturnSearch\SalesReturnSearchConfig;
use Spryker\Shared\TaxProductStorage\TaxProductStorageConfig;
use Spryker\Shared\TaxStorage\TaxStorageConfig;
use Spryker\Shared\UrlStorage\UrlStorageConstants;
use Spryker\Zed\Event\Communication\Plugin\Queue\EventQueueMessageProcessorPlugin;
use Spryker\Zed\Event\Communication\Plugin\Queue\EventRetryQueueMessageProcessorPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Queue\QueueDependencyProvider as SprykerDependencyProvider;
use Spryker\Zed\Synchronization\Communication\Plugin\Queue\SynchronizationSearchQueueMessageProcessorPlugin;
use Spryker\Zed\Synchronization\Communication\Plugin\Queue\SynchronizationStorageQueueMessageProcessorPlugin;
use SprykerEco\Zed\Loggly\Communication\Plugin\LogglyLoggerQueueMessageProcessorPlugin;

class QueueDependencyProvider extends SprykerDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Queue\Dependency\Plugin\QueueMessageProcessorPluginInterface[]
     */
    protected function getProcessorMessagePlugins(Container $container)
    {
        return [
            EventConstants::EVENT_QUEUE => new EventQueueMessageProcessorPlugin(),
            EventConstants::EVENT_QUEUE_RETRY => new EventRetryQueueMessageProcessorPlugin(),
            PublisherConfig::PUBLISH_QUEUE => new EventQueueMessageProcessorPlugin(),
            PublisherConfig::PUBLISH_RETRY_QUEUE => new EventRetryQueueMessageProcessorPlugin(),
            GlossaryStorageConfig::PUBLISH_TRANSLATION => new EventQueueMessageProcessorPlugin(),
            Config::get(LogConstants::LOG_QUEUE_NAME) => new LogglyLoggerQueueMessageProcessorPlugin(),
            CmsStorageConstants::CMS_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            AvailabilityStorageConstants::AVAILABILITY_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            CustomerAccessStorageConstants::CUSTOMER_ACCESS_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            GlossaryStorageConfig::SYNC_STORAGE_TRANSLATION => new SynchronizationStorageQueueMessageProcessorPlugin(),
            UrlStorageConstants::URL_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            ProductStorageConstants::PRODUCT_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            PriceProductStorageConstants::PRICE_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            CategoryStorageConstants::CATEGORY_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            CmsPageSearchConstants::CMS_SYNC_SEARCH_QUEUE => new SynchronizationSearchQueueMessageProcessorPlugin(),
            CategoryPageSearchConstants::CATEGORY_SYNC_SEARCH_QUEUE => new SynchronizationSearchQueueMessageProcessorPlugin(),
            ProductPageSearchConstants::PRODUCT_SYNC_SEARCH_QUEUE => new SynchronizationSearchQueueMessageProcessorPlugin(),
            FileManagerStorageConstants::FILE_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            TaxStorageConfig::TAX_SET_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            TaxProductStorageConfig::PRODUCT_ABSTRACT_TAX_SET_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            ContentStorageConfig::CONTENT_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            ConfigurableBundleStorageConfig::CONFIGURABLE_BUNDLE_SYNC_STORAGE_QUEUE => new SynchronizationStorageQueueMessageProcessorPlugin(),
            ConfigurableBundlePageSearchConfig::CONFIGURABLE_BUNDLE_SEARCH_QUEUE => new SynchronizationSearchQueueMessageProcessorPlugin(),
            SalesReturnSearchConfig::SYNC_SEARCH_RETURN => new SynchronizationSearchQueueMessageProcessorPlugin(),
        ];
    }
}
