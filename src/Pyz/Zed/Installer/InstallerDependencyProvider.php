<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Installer;

use Generated\Shared\Transfer\StockConditionsTransfer;
use Generated\Shared\Transfer\StockCriteriaTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\UserConditionsTransfer;
use Generated\Shared\Transfer\UserCriteriaTransfer;
use Generated\Shared\Transfer\WarehouseUserAssignmentCollectionRequestTransfer;
use Generated\Shared\Transfer\WarehouseUserAssignmentTransfer;
use Spryker\Zed\Acl\Communication\Plugin\AclInstallerPlugin;
use Spryker\Zed\Country\Communication\Plugin\CountryInstallerPlugin;
use Spryker\Zed\CustomerAccess\Communication\Plugin\CustomerAccessInstallerPlugin;
use Spryker\Zed\DynamicEntity\Communication\Plugin\Installer\DynamicEntityInstallerPlugin;
use Spryker\Zed\Glossary\Communication\Plugin\GlossaryInstallerPlugin;
use Spryker\Zed\Installer\InstallerDependencyProvider as SprykerInstallerDependencyProvider;
use Spryker\Zed\InstallerExtension\Dependency\Plugin\InstallerPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Locale\Communication\Plugin\LocaleInstallerPlugin;
use Spryker\Zed\Newsletter\Communication\Plugin\NewsletterInstallerPlugin;
use Spryker\Zed\Oauth\Communication\Plugin\Installer\OauthClientInstallerPlugin;
use Spryker\Zed\OauthAgentConnector\Communication\Plugin\Installer\AgentOauthScopeInstallerPlugin;
use Spryker\Zed\OauthCustomerConnector\Communication\Plugin\Installer\OauthCustomerScopeInstallerPlugin;
use Spryker\Zed\OauthWarehouse\Communication\Plugin\Installer\OauthWarehouseInstallerPlugin;
use Spryker\Zed\PriceProduct\Communication\Plugin\PriceInstallerPlugin;
use Spryker\Zed\ProductAlternativeProductLabelConnector\Communication\Plugin\Installer\ProductAlternativeProductLabelConnectorInstallerPlugin;
use Spryker\Zed\ProductDiscontinuedProductLabelConnector\Communication\Plugin\Installer\ProductDiscontinuedProductLabelConnectorInstallerPlugin;
use Spryker\Zed\PushNotificationWebPushPhp\Communication\Plugin\Installer\PushNotificationWebPushPhpProviderInstallerPlugin;
use Spryker\Zed\SalesOrderThreshold\Communication\Plugin\Installer\SalesOrderThresholdTypeInstallerPlugin;
use Spryker\Zed\Stock\Business\StockFacade;
use Spryker\Zed\Translator\Communication\Plugin\TranslatorInstallerPlugin;
use Spryker\Zed\User\Business\UserFacade;
use Spryker\Zed\User\Communication\Plugin\UserInstallerPlugin;
use Spryker\Zed\WarehouseUser\Business\WarehouseUserFacade;

class InstallerDependencyProvider extends SprykerInstallerDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\Installer\Dependency\Plugin\InstallerPluginInterface|\Spryker\Zed\InstallerExtension\Dependency\Plugin\InstallerPluginInterface>
     */
    public function getInstallerPlugins(): array
    {
        return [
            new PriceInstallerPlugin(),
            new LocaleInstallerPlugin(),
            new CountryInstallerPlugin(),
            new UserInstallerPlugin(),
            new AclInstallerPlugin(),
            new NewsletterInstallerPlugin(),
            new GlossaryInstallerPlugin(),
            new CustomerAccessInstallerPlugin(),
            new TranslatorInstallerPlugin(),
            new ProductAlternativeProductLabelConnectorInstallerPlugin(), #ProductAlternativeFeature
            new ProductDiscontinuedProductLabelConnectorInstallerPlugin(), #ProductDiscontinuedFeature
            new SalesOrderThresholdTypeInstallerPlugin(), #SalesOrderThresholdFeature
            new OauthClientInstallerPlugin(),
            new OauthCustomerScopeInstallerPlugin(),
            new AgentOauthScopeInstallerPlugin(),
            new DynamicEntityInstallerPlugin(),
            new PushNotificationWebPushPhpProviderInstallerPlugin(),
            new OauthWarehouseInstallerPlugin(),
            // For E2E tests purpose only, should not be used in production.
            new class extends AbstractPlugin implements InstallerPluginInterface {
                public function install(): void
                {
                    $userTransfer = (new UserFacade())->getUserCollection(
                        (new UserCriteriaTransfer())->setUserConditions((new UserConditionsTransfer())->addUsername('harald@spryker.com')),
                    )->getUsers()->getIterator()->current();

                    $stockTransfer = (new StockFacade())->getStockCollection(
                        (new StockCriteriaTransfer())->setStockConditions(
                            (new StockConditionsTransfer())->addStockName('Warehouse1'),
                        ),
                    )->getStocks()->getIterator()->current();

                    $warehouseUserAssignmentCollectionRequestTransfer = (new WarehouseUserAssignmentCollectionRequestTransfer())
                        ->addWarehouseUserAssignment(
                            (new WarehouseUserAssignmentTransfer())
                                ->setUserUuid($userTransfer->getUuid())
                                ->setWarehouse((new StockTransfer())->setUuid($stockTransfer->getUuid())),
                        );

                    (new WarehouseUserFacade())
                        ->createWarehouseUserAssignmentCollection(
                            $warehouseUserAssignmentCollectionRequestTransfer,
                        );
                }
            },
        ];
    }
}
