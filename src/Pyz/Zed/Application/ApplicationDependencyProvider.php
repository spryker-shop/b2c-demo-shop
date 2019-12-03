<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Application;

use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Spryker\Shared\Application\ServiceProvider\FormFactoryServiceProvider;
use Spryker\Shared\ErrorHandler\Plugin\ServiceProvider\WhoopsErrorHandlerServiceProvider;
use Spryker\Zed\Acl\Communication\Plugin\Bootstrap\AclBootstrapProvider;
use Spryker\Zed\Application\ApplicationDependencyProvider as SprykerApplicationDependencyProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\RequestServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\SaveSessionServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\SubRequestServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\ZedHstsServiceProvider;
use Spryker\Zed\Assertion\Communication\Plugin\ServiceProvider\AssertionServiceProvider;
use Spryker\Zed\Auth\Communication\Plugin\Bootstrap\AuthBootstrapProvider;
use Spryker\Zed\Auth\Communication\Plugin\ServiceProvider\RedirectAfterLoginProvider;
use Spryker\Zed\EventBehavior\Communication\Plugin\ServiceProvider\EventBehaviorServiceProvider;
use Spryker\Zed\EventDispatcher\Communication\Plugin\Application\EventDispatcherApplicationPlugin;
use Spryker\Zed\Gui\Communication\Plugin\ServiceProvider\FormTypeExtensionServiceProvider;
use Spryker\Zed\Http\Communication\Plugin\Application\HttpApplicationPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Locale\Communication\Plugin\Application\LocaleApplicationPlugin;
use Spryker\Zed\Messenger\Communication\Plugin\Application\MessengerApplicationPlugin;
use Spryker\Zed\Monitoring\Communication\Plugin\ServiceProvider\MonitoringRequestTransactionServiceProvider;
use Spryker\Zed\Propel\Communication\Plugin\Application\PropelApplicationPlugin;
use Spryker\Zed\Router\Communication\Plugin\Application\RouterApplicationPlugin;
use Spryker\Zed\Session\Communication\Plugin\ServiceProvider\SessionServiceProvider as SprykerSessionServiceProvider;
use Spryker\Zed\Translator\Communication\Plugin\Application\TranslatorApplicationPlugin;
use Spryker\Zed\Twig\Communication\Plugin\Application\TwigApplicationPlugin;
use Spryker\Zed\WebProfiler\Communication\Plugin\ServiceProvider\WebProfilerServiceProvider;
use Spryker\Zed\ZedRequest\Communication\Plugin\GatewayServiceProviderPlugin;

class ApplicationDependencyProvider extends SprykerApplicationDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getServiceProviders(Container $container)
    {
        $coreProviders = parent::getServiceProviders($container);

        $providers = [
            new SessionServiceProvider(),
            new SprykerSessionServiceProvider(),
            new AssertionServiceProvider(),
            new SubRequestServiceProvider(),
            new FormFactoryServiceProvider(),
            new EventBehaviorServiceProvider(),
            new SaveSessionServiceProvider(),
            new FormTypeExtensionServiceProvider(),
        ];

        $providers = array_merge($providers, $coreProviders);

        return $providers;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getApiServiceProviders(Container $container)
    {
        $providers = [
            // Add Auth service providers
            new RequestServiceProvider(),
            new EventBehaviorServiceProvider(),
        ];

        if ($this->getConfig()->isPrettyErrorHandlerEnabled()) {
            $providers[] = new WhoopsErrorHandlerServiceProvider();
        }

        return $providers;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getInternalCallServiceProviders(Container $container)
    {
        return [
            new RequestServiceProvider(),
            new GatewayServiceProviderPlugin(),
            new MonitoringRequestTransactionServiceProvider(),
            new SubRequestServiceProvider(),
            new EventBehaviorServiceProvider(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Silex\ServiceProviderInterface[]
     */
    protected function getInternalCallServiceProvidersWithAuthentication(Container $container)
    {
        return [
            new RequestServiceProvider(),
            new SessionServiceProvider(),
            new SprykerSessionServiceProvider(),
            new SubRequestServiceProvider(),
            new EventBehaviorServiceProvider(),
        ];
    }

    /**
     * @return \Spryker\Shared\ApplicationExtension\Dependency\Plugin\ApplicationPluginInterface[]
     */
    protected function getApplicationPlugins(): array
    {
        return [
            new TwigApplicationPlugin(),
            new EventDispatcherApplicationPlugin(),
            new LocaleApplicationPlugin(),
            new TranslatorApplicationPlugin(),
            new PropelApplicationPlugin(),
            new MessengerApplicationPlugin(),
            new RouterApplicationPlugin(),
            new HttpApplicationPlugin(),
        ];
    }
}
