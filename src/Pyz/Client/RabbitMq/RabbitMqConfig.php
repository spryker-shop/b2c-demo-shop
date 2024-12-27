<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\RabbitMq;

use Spryker\Client\RabbitMq\RabbitMqConfig as SprykerRabbitMqConfig;
use Spryker\Shared\AssetStorage\AssetStorageConfig;
use Spryker\Shared\AvailabilityStorage\AvailabilityStorageConfig;
use Spryker\Shared\AvailabilityStorage\AvailabilityStorageConstants;
use Spryker\Shared\CategoryPageSearch\CategoryPageSearchConstants;
use Spryker\Shared\CategoryStorage\CategoryStorageConstants;
use Spryker\Shared\CmsPageSearch\CmsPageSearchConstants;
use Spryker\Shared\CmsStorage\CmsStorageConstants;
use Spryker\Shared\ConfigurableBundlePageSearch\ConfigurableBundlePageSearchConfig;
use Spryker\Shared\ConfigurableBundleStorage\ConfigurableBundleStorageConfig;
use Spryker\Shared\ContentStorage\ContentStorageConfig;
use Spryker\Shared\CustomerAccessStorage\CustomerAccessStorageConstants;
use Spryker\Shared\CustomerStorage\CustomerStorageConfig;
use Spryker\Shared\Event\EventConfig;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\FileManagerStorage\FileManagerStorageConstants;
use Spryker\Shared\GlossaryStorage\GlossaryStorageConfig;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\PriceProductStorage\PriceProductStorageConfig;
use Spryker\Shared\PriceProductStorage\PriceProductStorageConstants;
use Spryker\Shared\ProductConfigurationStorage\ProductConfigurationStorageConfig;
use Spryker\Shared\ProductImageStorage\ProductImageStorageConfig;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConfig;
use Spryker\Shared\ProductPageSearch\ProductPageSearchConstants;
use Spryker\Shared\ProductStorage\ProductStorageConfig;
use Spryker\Shared\ProductStorage\ProductStorageConstants;
use Spryker\Shared\PublishAndSynchronizeHealthCheck\PublishAndSynchronizeHealthCheckConfig;
use Spryker\Shared\PublishAndSynchronizeHealthCheckSearch\PublishAndSynchronizeHealthCheckSearchConfig;
use Spryker\Shared\PublishAndSynchronizeHealthCheckStorage\PublishAndSynchronizeHealthCheckStorageConfig;
use Spryker\Shared\Publisher\PublisherConfig;
use Spryker\Shared\RabbitMq\RabbitMqEnv;
use Spryker\Shared\SalesReturnSearch\SalesReturnSearchConfig;
use Spryker\Shared\SearchHttp\SearchHttpConfig;
use Spryker\Shared\StoreStorage\StoreStorageConfig;
use Spryker\Shared\TaxProductStorage\TaxProductStorageConfig;
use Spryker\Shared\TaxStorage\TaxStorageConfig;
use Spryker\Shared\UrlStorage\UrlStorageConfig;
use Spryker\Shared\UrlStorage\UrlStorageConstants;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RabbitMqConfig extends SprykerRabbitMqConfig
{
    /**
     * @return array<string, array<int, string>>
     */
    public function getQueuePools(): array
    {
        return [
            'synchronizationPool' => $this->getQueueConnectionNames(),
        ];
    }

    /**
     * @return string|null
     */
    public function getDefaultLocaleCode(): ?string
    {
        return 'en_US';
    }

    /**
     *  QueueNameFoo, // Queue => QueueNameFoo, (Queue and error queue will be created: QueueNameFoo and QueueNameFoo.error)
     *  QueueNameBar => [
     *       RoutingKeyFoo => QueueNameBaz, // (Additional queues can be defined by several routing keys)
     *   ],
     *
     * @see https://www.rabbitmq.com/tutorials/amqp-concepts.html
     *
     * @return array<mixed>
     */
    protected function getQueueConfiguration(): array
    {
        return array_merge(
            [
                EventConstants::EVENT_QUEUE => [
                    EventConfig::EVENT_ROUTING_KEY_RETRY => EventConstants::EVENT_QUEUE_RETRY,
                    EventConfig::EVENT_ROUTING_KEY_ERROR => EventConstants::EVENT_QUEUE_ERROR,
                ],
                $this->get(LogConstants::LOG_QUEUE_NAME),
            ],
            $this->getPublishQueueConfiguration(),
            $this->getSynchronizationQueueConfiguration(),
        );
    }

    /**
     * @return array<mixed>
     */
    protected function getPublishQueueConfiguration(): array
    {
        return [
            PublisherConfig::PUBLISH_QUEUE => [
                PublisherConfig::PUBLISH_ROUTING_KEY_RETRY => PublisherConfig::PUBLISH_RETRY_QUEUE,
                PublisherConfig::PUBLISH_ROUTING_KEY_ERROR => PublisherConfig::PUBLISH_ERROR_QUEUE,
            ],
            GlossaryStorageConfig::PUBLISH_TRANSLATION,
            PublishAndSynchronizeHealthCheckConfig::PUBLISH_PUBLISH_AND_SYNCHRONIZE_HEALTH_CHECK,
            UrlStorageConfig::PUBLISH_URL,
            AvailabilityStorageConfig::PUBLISH_AVAILABILITY,
            PriceProductStorageConfig::PUBLISH_PRICE_PRODUCT_ABSTRACT,
            PriceProductStorageConfig::PUBLISH_PRICE_PRODUCT_CONCRETE,
            ProductImageStorageConfig::PUBLISH_PRODUCT_ABSTRACT_IMAGE,
            ProductImageStorageConfig::PUBLISH_PRODUCT_CONCRETE_IMAGE,
            ProductPageSearchConfig::PUBLISH_PRODUCT_ABSTRACT_PAGE,
            ProductPageSearchConfig::PUBLISH_PRODUCT_CONCRETE_PAGE,
            ProductStorageConfig::PUBLISH_PRODUCT_ABSTRACT,
            ProductStorageConfig::PUBLISH_PRODUCT_CONCRETE,
            CustomerStorageConfig::PUBLISH_CUSTOMER_INVALIDATED,
        ];
    }

    /**
     * @return array<mixed>
     */
    protected function getSynchronizationQueueConfiguration(): array
    {
        return [
            PublishAndSynchronizeHealthCheckSearchConfig::SYNC_SEARCH_PUBLISH_AND_SYNCHRONIZE_HEALTH_CHECK,
            PublishAndSynchronizeHealthCheckStorageConfig::SYNC_STORAGE_PUBLISH_AND_SYNCHRONIZE_HEALTH_CHECK,
            GlossaryStorageConfig::SYNC_STORAGE_TRANSLATION,
            UrlStorageConstants::URL_SYNC_STORAGE_QUEUE,
            AvailabilityStorageConstants::AVAILABILITY_SYNC_STORAGE_QUEUE,
            CustomerAccessStorageConstants::CUSTOMER_ACCESS_SYNC_STORAGE_QUEUE,
            CustomerStorageConfig::CUSTOMER_INVALIDATED_SYNC_STORAGE_QUEUE,
            CategoryStorageConstants::CATEGORY_SYNC_STORAGE_QUEUE,
            ProductStorageConstants::PRODUCT_SYNC_STORAGE_QUEUE,
            PriceProductStorageConstants::PRICE_SYNC_STORAGE_QUEUE,
            ConfigurableBundleStorageConfig::CONFIGURABLE_BUNDLE_SYNC_STORAGE_QUEUE,
            ConfigurableBundlePageSearchConfig::CONFIGURABLE_BUNDLE_SEARCH_QUEUE,
            CmsStorageConstants::CMS_SYNC_STORAGE_QUEUE,
            CategoryPageSearchConstants::CATEGORY_SYNC_SEARCH_QUEUE,
            CmsPageSearchConstants::CMS_SYNC_SEARCH_QUEUE,
            ProductPageSearchConstants::PRODUCT_SYNC_SEARCH_QUEUE,
            FileManagerStorageConstants::FILE_SYNC_STORAGE_QUEUE,
            ContentStorageConfig::CONTENT_SYNC_STORAGE_QUEUE,
            TaxProductStorageConfig::PRODUCT_ABSTRACT_TAX_SET_SYNC_STORAGE_QUEUE,
            TaxStorageConfig::TAX_SET_SYNC_STORAGE_QUEUE,
            SalesReturnSearchConfig::SYNC_SEARCH_RETURN,
            StoreStorageConfig::STORE_SYNC_STORAGE_QUEUE,
            AssetStorageConfig::ASSET_SYNC_STORAGE_QUEUE,
            ProductConfigurationStorageConfig::PRODUCT_CONFIGURATION_SYNC_STORAGE_QUEUE,
            SearchHttpConfig::SEARCH_HTTP_CONFIG_SYNC_QUEUE,
        ];
    }

    /**
     * @return string
     */
    protected function getDefaultBoundQueueNamePrefix(): string
    {
        return 'error';
    }

    /**
     * @return array<string>
     */
    protected function getQueueConnectionNames(): array
    {
        return array_map(
            function (array $connection): string {
                return $connection[RabbitMqEnv::RABBITMQ_CONNECTION_NAME];
            },
            $this->get(RabbitMqEnv::RABBITMQ_CONNECTIONS),
        );
    }
}
