<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Console;

use Pyz\Zed\DataImport\DataImportConfig;
use Pyz\Zed\Development\Communication\Console\AcceptanceCodeTestConsole;
use Pyz\Zed\Development\Communication\Console\ApiCodeTestConsole;
use Pyz\Zed\Development\Communication\Console\FunctionalCodeTestConsole;
use Pyz\Zed\Propel\Communication\Plugin\Application\PropelApplicationPlugin;
use Spryker\Shared\Config\Environment;
use Spryker\Zed\Cache\Communication\Console\EmptyAllCachesConsole;
use Spryker\Zed\CategoryDataImport\CategoryDataImportConfig;
use Spryker\Zed\CodeGenerator\Communication\Console\BundleClientCodeGeneratorConsole;
use Spryker\Zed\CodeGenerator\Communication\Console\BundleCodeGeneratorConsole;
use Spryker\Zed\CodeGenerator\Communication\Console\BundleServiceCodeGeneratorConsole;
use Spryker\Zed\CodeGenerator\Communication\Console\BundleSharedCodeGeneratorConsole;
use Spryker\Zed\CodeGenerator\Communication\Console\BundleYvesCodeGeneratorConsole;
use Spryker\Zed\CodeGenerator\Communication\Console\BundleZedCodeGeneratorConsole;
use Spryker\Zed\Console\Communication\Plugin\ConsoleLogPlugin;
use Spryker\Zed\Console\ConsoleDependencyProvider as SprykerConsoleDependencyProvider;
use Spryker\Zed\ContentNavigationDataImport\ContentNavigationDataImportConfig;
use Spryker\Zed\Customer\Communication\Console\CustomerPasswordResetConsole;
use Spryker\Zed\Customer\Communication\Console\CustomerPasswordSetConsole;
use Spryker\Zed\DataExport\Communication\Console\DataExportConsole;
use Spryker\Zed\DataImport\Communication\Console\DataImportConsole;
use Spryker\Zed\DataImport\Communication\Console\DataImportDumpConsole;
use Spryker\Zed\Development\Communication\Console\CodeArchitectureSnifferConsole;
use Spryker\Zed\Development\Communication\Console\CodeFixturesConsole;
use Spryker\Zed\Development\Communication\Console\CodePhpMessDetectorConsole;
use Spryker\Zed\Development\Communication\Console\CodePhpstanConsole;
use Spryker\Zed\Development\Communication\Console\CodeStyleSnifferConsole;
use Spryker\Zed\Development\Communication\Console\CodeTestConsole;
use Spryker\Zed\Development\Communication\Console\GenerateClientIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\GenerateGlueIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\GenerateIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\GenerateServiceIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\GenerateYvesIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\GenerateZedIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\PluginUsageFinderConsole;
use Spryker\Zed\Development\Communication\Console\RemoveClientIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\RemoveGlueIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\RemoveIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\RemoveServiceIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\RemoveYvesIdeAutoCompletionConsole;
use Spryker\Zed\Development\Communication\Console\RemoveZedIdeAutoCompletionConsole;
use Spryker\Zed\DocumentationGeneratorRestApi\Communication\Console\GenerateRestApiDocumentationConsole;
use Spryker\Zed\EventBehavior\Communication\Console\EventBehaviorTriggerTimeoutConsole;
use Spryker\Zed\EventBehavior\Communication\Console\EventTriggerListenerConsole;
use Spryker\Zed\EventBehavior\Communication\Plugin\Console\EventBehaviorPostHookPlugin;
use Spryker\Zed\IndexGenerator\Communication\Console\PostgresIndexGeneratorConsole;
use Spryker\Zed\IndexGenerator\Communication\Console\PostgresIndexRemoverConsole;
use Spryker\Zed\Installer\Communication\Console\InitializeDatabaseConsole;
use Spryker\Zed\Kernel\Communication\Console\ResolvableClassCacheConsole;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Log\Communication\Console\DeleteLogFilesConsole;
use Spryker\Zed\Maintenance\Communication\Console\MaintenanceDisableConsole;
use Spryker\Zed\Maintenance\Communication\Console\MaintenanceEnableConsole;
use Spryker\Zed\Monitoring\Communication\Plugin\Console\MonitoringConsolePlugin;
use Spryker\Zed\Oauth\Communication\Console\OauthTokenConsole;
use Spryker\Zed\Oms\Communication\Console\CheckConditionConsole as OmsCheckConditionConsole;
use Spryker\Zed\Oms\Communication\Console\CheckTimeoutConsole as OmsCheckTimeoutConsole;
use Spryker\Zed\Oms\Communication\Console\ClearLocksConsole as OmsClearLocksConsole;
use Spryker\Zed\PaymentDataImport\PaymentDataImportConfig;
use Spryker\Zed\PriceProduct\Communication\Console\PriceProductStoreOptimizeConsole;
use Spryker\Zed\PriceProductDataImport\PriceProductDataImportConfig;
use Spryker\Zed\PriceProductSchedule\Communication\Console\PriceProductScheduleApplyConsole;
use Spryker\Zed\PriceProductSchedule\Communication\Console\PriceProductScheduleCleanupConsole;
use Spryker\Zed\PriceProductScheduleDataImport\PriceProductScheduleDataImportConfig;
use Spryker\Zed\ProductAlternativeDataImport\ProductAlternativeDataImportConfig;
use Spryker\Zed\ProductDiscontinued\Communication\Console\DeactivateDiscontinuedProductsConsole;
use Spryker\Zed\ProductDiscontinuedDataImport\ProductDiscontinuedDataImportConfig;
use Spryker\Zed\ProductLabel\Communication\Console\ProductLabelRelationUpdaterConsole;
use Spryker\Zed\ProductLabel\Communication\Console\ProductLabelValidityConsole;
use Spryker\Zed\ProductLabelDataImport\ProductLabelDataImportConfig;
use Spryker\Zed\ProductQuantityDataImport\ProductQuantityDataImportConfig;
use Spryker\Zed\ProductRelation\Communication\Console\ProductRelationUpdaterConsole;
use Spryker\Zed\ProductRelationDataImport\ProductRelationDataImportConfig;
use Spryker\Zed\ProductValidity\Communication\Console\ProductValidityConsole;
use Spryker\Zed\Propel\Communication\Console\DatabaseDropConsole;
use Spryker\Zed\Propel\Communication\Console\DatabaseDropTablesConsole;
use Spryker\Zed\Propel\Communication\Console\DeleteMigrationFilesConsole;
use Spryker\Zed\Propel\Communication\Console\DeployPreparePropelConsole;
use Spryker\Zed\Propel\Communication\Console\EntityTransferGeneratorConsole;
use Spryker\Zed\Propel\Communication\Console\PropelSchemaValidatorConsole;
use Spryker\Zed\Propel\Communication\Console\PropelSchemaXmlNameValidatorConsole;
use Spryker\Zed\Propel\Communication\Console\RemoveEntityTransferConsole;
use Spryker\Zed\Publisher\Communication\Console\PublisherTriggerEventsConsole;
use Spryker\Zed\Queue\Communication\Console\QueueDumpConsole;
use Spryker\Zed\Queue\Communication\Console\QueueTaskConsole;
use Spryker\Zed\Queue\Communication\Console\QueueWorkerConsole;
use Spryker\Zed\Quote\Communication\Console\DeleteExpiredGuestQuoteConsole;
use Spryker\Zed\RabbitMq\Communication\Console\DeleteAllExchangesConsole;
use Spryker\Zed\RabbitMq\Communication\Console\DeleteAllQueuesConsole;
use Spryker\Zed\RabbitMq\Communication\Console\PurgeAllQueuesConsole;
use Spryker\Zed\RabbitMq\Communication\Console\SetUserPermissionsConsole;
use Spryker\Zed\RestRequestValidator\Communication\Console\BuildRestApiValidationCacheConsole;
use Spryker\Zed\RestRequestValidator\Communication\Console\RemoveRestApiValidationCacheConsole;
use Spryker\Zed\Router\Communication\Plugin\Console\RouterCacheWarmUpConsole;
use Spryker\Zed\SalesInvoice\Communication\Console\OrderInvoiceSendConsole;
use Spryker\Zed\Scheduler\Communication\Console\SchedulerCleanConsole;
use Spryker\Zed\Scheduler\Communication\Console\SchedulerResumeConsole;
use Spryker\Zed\Scheduler\Communication\Console\SchedulerSetupConsole;
use Spryker\Zed\Scheduler\Communication\Console\SchedulerSuspendConsole;
use Spryker\Zed\Search\Communication\Console\GenerateSourceMapConsole;
use Spryker\Zed\Search\Communication\Console\RemoveSourceMapConsole;
use Spryker\Zed\Search\Communication\Console\SearchConsole;
use Spryker\Zed\Search\Communication\Console\SearchSetupSourcesConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchCloseIndexConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchCopyIndexConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchDeleteIndexConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchOpenIndexConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchSnapshotCreateConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchSnapshotDeleteConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchSnapshotRegisterRepositoryConsole;
use Spryker\Zed\SearchElasticsearch\Communication\Console\ElasticsearchSnapshotRestoreConsole;
use Spryker\Zed\Session\Communication\Console\SessionRemoveLockConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\CleanUpDependenciesConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\InstallPackageManagerConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\InstallProjectDependenciesConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\Npm\RunnerConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\YvesBuildFrontendConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\YvesInstallDependenciesConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\ZedBuildFrontendConsole;
use Spryker\Zed\SetupFrontend\Communication\Console\ZedInstallDependenciesConsole;
use Spryker\Zed\ShipmentDataImport\ShipmentDataImportConfig;
use Spryker\Zed\StateMachine\Communication\Console\CheckConditionConsole as StateMachineCheckConditionConsole;
use Spryker\Zed\StateMachine\Communication\Console\CheckTimeoutConsole as StateMachineCheckTimeoutConsole;
use Spryker\Zed\StateMachine\Communication\Console\ClearLocksConsole as StateMachineClearLocksConsole;
use Spryker\Zed\StockDataImport\StockDataImportConfig;
use Spryker\Zed\Storage\Communication\Console\StorageDeleteAllConsole;
use Spryker\Zed\StorageRedis\Communication\Console\StorageRedisExportRdbConsole;
use Spryker\Zed\StorageRedis\Communication\Console\StorageRedisImportRdbConsole;
use Spryker\Zed\Synchronization\Communication\Console\ExportSynchronizedDataConsole;
use Spryker\Zed\Transfer\Communication\Console\DataBuilderGeneratorConsole;
use Spryker\Zed\Transfer\Communication\Console\RemoveDataBuilderConsole;
use Spryker\Zed\Transfer\Communication\Console\RemoveTransferConsole;
use Spryker\Zed\Transfer\Communication\Console\TransferGeneratorConsole;
use Spryker\Zed\Transfer\Communication\Console\ValidatorConsole;
use Spryker\Zed\Translator\Communication\Console\CleanTranslationCacheConsole;
use Spryker\Zed\Translator\Communication\Console\GenerateTranslationCacheConsole;
use Spryker\Zed\Twig\Communication\Console\CacheWarmerConsole;
use Spryker\Zed\Twig\Communication\Plugin\Application\TwigApplicationPlugin;
use Spryker\Zed\Uuid\Communication\Console\UuidGeneratorConsole;
use Spryker\Zed\ZedNavigation\Communication\Console\BuildNavigationConsole;
use Spryker\Zed\ZedNavigation\Communication\Console\RemoveNavigationCacheConsole;
use SprykerSdk\Spryk\Console\SprykBuildConsole;
use SprykerSdk\Spryk\Console\SprykDumpConsole;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdk\Zed\ComposerConstrainer\Communication\Console\ComposerConstraintConsole;
use Stecman\Component\Symfony\Console\BashCompletion\CompletionCommand;

/**
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 * @method \Pyz\Zed\Console\ConsoleConfig getConfig()
 */
class ConsoleDependencyProvider extends SprykerConsoleDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    protected function getConsoleCommands(Container $container)
    {
        $commands = [
            new CacheWarmerConsole(),
            new BuildNavigationConsole(),
            new RemoveNavigationCacheConsole(),
            new EmptyAllCachesConsole(),
            new TransferGeneratorConsole(),
            new RemoveTransferConsole(),
            new EntityTransferGeneratorConsole(),
            new RemoveEntityTransferConsole(),
            new InitializeDatabaseConsole(),
            new SearchConsole(),
            new GenerateSourceMapConsole(),
            new RemoveSourceMapConsole(),
            new SearchSetupSourcesConsole(),
            new OmsCheckConditionConsole(),
            new OmsCheckTimeoutConsole(),
            new OmsClearLocksConsole(),
            new StateMachineCheckTimeoutConsole(),
            new StateMachineCheckConditionConsole(),
            new StateMachineClearLocksConsole(),
            new SessionRemoveLockConsole(),
            new QueueTaskConsole(),
            new QueueWorkerConsole(),
            new ProductRelationUpdaterConsole(),
            new ProductLabelValidityConsole(),
            new ProductLabelRelationUpdaterConsole(),
            new ProductValidityConsole(),
            new OauthTokenConsole(),
            new DataImportConsole(),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_STORE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_CURRENCY),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . CategoryDataImportConfig::IMPORT_TYPE_CATEGORY),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_CATEGORY_TEMPLATE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_CUSTOMER),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_GLOSSARY),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_NAVIGATION),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_NAVIGATION_NODE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_CMS_TEMPLATE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_CMS_BLOCK),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_CMS_BLOCK_STORE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_DISCOUNT),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_DISCOUNT_STORE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_DISCOUNT_VOUCHER),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_ABSTRACT),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_ABSTRACT_STORE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_CONCRETE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_IMAGE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_STOCK),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_ATTRIBUTE_KEY),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_MANAGEMENT_ATTRIBUTE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_GROUP),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_OPTION),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_OPTION_PRICE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_REVIEW),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ProductLabelDataImportConfig::IMPORT_TYPE_PRODUCT_LABEL),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ProductLabelDataImportConfig::IMPORT_TYPE_PRODUCT_LABEL_STORE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_SET),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_SEARCH_ATTRIBUTE_MAP),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_PRODUCT_SEARCH_ATTRIBUTE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ShipmentDataImportConfig::IMPORT_TYPE_SHIPMENT),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ShipmentDataImportConfig::IMPORT_TYPE_SHIPMENT_PRICE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_TAX),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_DISCOUNT_AMOUNT),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ProductAlternativeDataImportConfig::IMPORT_TYPE_PRODUCT_ALTERNATIVE), #ProductAlternativeFeature
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ProductDiscontinuedDataImportConfig::IMPORT_TYPE_PRODUCT_DISCONTINUED),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . PriceProductScheduleDataImportConfig::IMPORT_TYPE_PRODUCT_PRICE_SCHEDULE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_ABSTRACT_GIFT_CARD_CONFIGURATION), #GiftCardFeature
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . DataImportConfig::IMPORT_TYPE_CONCRETE_GIFT_CARD_CONFIGURATION),

            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ShipmentDataImportConfig::IMPORT_TYPE_SHIPMENT),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ShipmentDataImportConfig::IMPORT_TYPE_SHIPMENT_PRICE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ShipmentDataImportConfig::IMPORT_TYPE_SHIPMENT_METHOD_STORE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . StockDataImportConfig::IMPORT_TYPE_STOCK),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . StockDataImportConfig::IMPORT_TYPE_STOCK_STORE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ContentNavigationDataImportConfig::IMPORT_TYPE_CONTENT_NAVIGATION),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . PaymentDataImportConfig::IMPORT_TYPE_PAYMENT_METHOD),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . PaymentDataImportConfig::IMPORT_TYPE_PAYMENT_METHOD_STORE),

            //core data importers
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . PriceProductDataImportConfig::IMPORT_TYPE_PRODUCT_PRICE),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ProductQuantityDataImportConfig::IMPORT_TYPE_PRODUCT_QUANTITY),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ProductRelationDataImportConfig::IMPORT_TYPE_PRODUCT_RELATION),
            new DataImportConsole(DataImportConsole::DEFAULT_NAME . ':' . ProductRelationDataImportConfig::IMPORT_TYPE_PRODUCT_RELATION_STORE),

            // Publish and Synchronization
            new EventBehaviorTriggerTimeoutConsole(),
            new PublisherTriggerEventsConsole(),
            new ExportSynchronizedDataConsole(),

            // Setup commands
            new RunnerConsole(),
            new DeployPreparePropelConsole(),

            new DatabaseDropConsole(),
            new DatabaseDropTablesConsole(),

            new DeleteMigrationFilesConsole(),

            new DeleteLogFilesConsole(),
            new StorageRedisExportRdbConsole(),
            new StorageRedisImportRdbConsole(),
            new StorageDeleteAllConsole(),
            new ElasticsearchCloseIndexConsole(),
            new ElasticsearchCopyIndexConsole(),
            new ElasticsearchDeleteIndexConsole(),
            new ElasticsearchOpenIndexConsole(),
            new ElasticsearchSnapshotRegisterRepositoryConsole(),
            new ElasticsearchSnapshotDeleteConsole(),
            new ElasticsearchSnapshotCreateConsole(),
            new ElasticsearchSnapshotRestoreConsole(),

            new InstallPackageManagerConsole(),
            new CleanUpDependenciesConsole(),
            new InstallProjectDependenciesConsole(),

            new YvesInstallDependenciesConsole(),
            new YvesBuildFrontendConsole(),

            new ZedInstallDependenciesConsole(),
            new ZedBuildFrontendConsole(),

            new DeleteAllQueuesConsole(),
            new PurgeAllQueuesConsole(),
            new DeleteAllExchangesConsole(),
            new SetUserPermissionsConsole(),

            new MaintenanceEnableConsole(),
            new MaintenanceDisableConsole(),

            new DeactivateDiscontinuedProductsConsole(), #ProductDiscontinuedFeature

            new PriceProductStoreOptimizeConsole(),

            new UuidGeneratorConsole(),
            new DeleteExpiredGuestQuoteConsole(),
            new BuildRestApiValidationCacheConsole(),
            new RemoveRestApiValidationCacheConsole(),

            new CleanTranslationCacheConsole(),
            new GenerateTranslationCacheConsole(),

            new PriceProductScheduleApplyConsole(),
            new PriceProductScheduleCleanupConsole(),

            new SchedulerSetupConsole(),
            new SchedulerCleanConsole(),
            new SchedulerSuspendConsole(),
            new SchedulerResumeConsole(),

            new RouterCacheWarmUpConsole(),

            new ResolvableClassCacheConsole(),

            new DataExportConsole(),
            new CustomerPasswordResetConsole(),
            new CustomerPasswordSetConsole(),

            new OrderInvoiceSendConsole(),
        ];

        $propelCommands = $container->getLocator()->propel()->facade()->getConsoleCommands();
        $commands = array_merge($commands, $propelCommands);

        if ($this->getConfig()->isDevelopmentConsoleCommandsEnabled()) {
            $commands[] = new CodeTestConsole();
            $commands[] = new CodeFixturesConsole();
            $commands[] = new AcceptanceCodeTestConsole();
            $commands[] = new FunctionalCodeTestConsole();
            $commands[] = new ApiCodeTestConsole();
            $commands[] = new CodeStyleSnifferConsole();
            $commands[] = new CodeArchitectureSnifferConsole();
            $commands[] = new CodePhpstanConsole();
            $commands[] = new CodePhpMessDetectorConsole();
            $commands[] = new ValidatorConsole();
            $commands[] = new BundleCodeGeneratorConsole();
            $commands[] = new BundleYvesCodeGeneratorConsole();
            $commands[] = new BundleZedCodeGeneratorConsole();
            $commands[] = new BundleServiceCodeGeneratorConsole();
            $commands[] = new BundleSharedCodeGeneratorConsole();
            $commands[] = new BundleClientCodeGeneratorConsole();
            $commands[] = new GenerateZedIdeAutoCompletionConsole();
            $commands[] = new RemoveZedIdeAutoCompletionConsole();
            $commands[] = new GenerateClientIdeAutoCompletionConsole();
            $commands[] = new RemoveClientIdeAutoCompletionConsole();
            $commands[] = new GenerateServiceIdeAutoCompletionConsole();
            $commands[] = new RemoveServiceIdeAutoCompletionConsole();
            $commands[] = new GenerateYvesIdeAutoCompletionConsole();
            $commands[] = new RemoveYvesIdeAutoCompletionConsole();
            $commands[] = new GenerateIdeAutoCompletionConsole();
            $commands[] = new RemoveIdeAutoCompletionConsole();
            $commands[] = new DataBuilderGeneratorConsole();
            $commands[] = new RemoveDataBuilderConsole();
            $commands[] = new CompletionCommand();
            $commands[] = new DataBuilderGeneratorConsole();
            $commands[] = new PropelSchemaValidatorConsole();
            $commands[] = new PropelSchemaXmlNameValidatorConsole();
            $commands[] = new DataImportDumpConsole();
            $commands[] = new GenerateGlueIdeAutoCompletionConsole();
            $commands[] = new RemoveGlueIdeAutoCompletionConsole();
            $commands[] = new PluginUsageFinderConsole();
            $commands[] = new PostgresIndexGeneratorConsole();
            $commands[] = new PostgresIndexRemoverConsole();
            $commands[] = new GenerateRestApiDocumentationConsole();
            $commands[] = new QueueDumpConsole();
            $commands[] = new EventTriggerListenerConsole();

            $commands[] = new SprykRunConsole();
            $commands[] = new SprykDumpConsole();
            $commands[] = new SprykBuildConsole();
            $commands[] = new ComposerConstraintConsole();
        }

        return $commands;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Symfony\Component\EventDispatcher\EventSubscriberInterface[]
     */
    public function getEventSubscriber(Container $container)
    {
        $eventSubscriber = parent::getEventSubscriber($container);

        if (!Environment::isDevelopment()) {
            $eventSubscriber[] = new ConsoleLogPlugin();
            $eventSubscriber[] = new MonitoringConsolePlugin();
        }

        return $eventSubscriber;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return array
     */
    public function getConsolePostRunHookPlugins(Container $container)
    {
        return [
            new EventBehaviorPostHookPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface[]
     */
    protected function getApplicationPlugins(Container $container): array
    {
        $applicationPlugins = parent::getApplicationPlugins($container);
        $applicationPlugins[] = new PropelApplicationPlugin();
        $applicationPlugins[] = new TwigApplicationPlugin();

        return $applicationPlugins;
    }
}
