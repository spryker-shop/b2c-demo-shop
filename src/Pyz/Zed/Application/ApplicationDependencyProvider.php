<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Application;

use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Spryker\Service\UtilDateTime\ServiceProvider\DateTimeFormatterServiceProvider;
use Spryker\Shared\Application\ServiceProvider\FormFactoryServiceProvider;
use Spryker\Shared\Config\Environment;
use Spryker\Shared\ErrorHandler\Plugin\ServiceProvider\WhoopsErrorHandlerServiceProvider;
use Spryker\Zed\Acl\Communication\Plugin\Bootstrap\AclBootstrapProvider;
use Spryker\Zed\Api\Communication\Plugin\ApiServiceProviderPlugin;
use Spryker\Zed\Api\Communication\Plugin\ServiceProvider\ApiRoutingServiceProvider;
use Spryker\Zed\Application\ApplicationDependencyProvider as SprykerApplicationDependencyProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\AssertUrlConfigurationServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\EnvironmentInformationServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\MvcRoutingServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\RequestServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\RoutingServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\SilexRoutingServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\SslServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\SubRequestServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\TranslationServiceProvider;
use Spryker\Zed\Application\Communication\Plugin\ServiceProvider\ZedHstsServiceProvider;
use Spryker\Zed\Assertion\Communication\Plugin\ServiceProvider\AssertionServiceProvider;
use Spryker\Zed\Auth\Communication\Plugin\Bootstrap\AuthBootstrapProvider;
use Spryker\Zed\Auth\Communication\Plugin\ServiceProvider\RedirectAfterLoginProvider;
use Spryker\Zed\Currency\Communication\Plugin\ServiceProvider\TwigCurrencyServiceProvider;
use Spryker\Zed\EventBehavior\Communication\Plugin\ServiceProvider\EventBehaviorServiceProvider;
use Spryker\Zed\Gui\Communication\Plugin\ServiceProvider\GuiTwigExtensionServiceProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Messenger\Communication\Plugin\ServiceProvider\MessengerServiceProvider;
use Spryker\Zed\Money\Communication\Plugin\ServiceProvider\TwigMoneyServiceProvider;
use Spryker\Zed\Monitoring\Communication\Plugin\ServiceProvider\MonitoringRequestTransactionServiceProvider;
use Spryker\Zed\Propel\Communication\Plugin\ServiceProvider\PropelServiceProvider;
use Spryker\Zed\Session\Communication\Plugin\ServiceProvider\SessionServiceProvider as SprykerSessionServiceProvider;
use Spryker\Zed\Twig\Communication\Plugin\ServiceProvider\TwigServiceProvider as SprykerTwigServiceProvider;
use Spryker\Zed\User\Communication\Plugin\ServiceProvider\UserServiceProvider;
use Spryker\Zed\WebProfiler\Communication\Plugin\ServiceProvider\WebProfilerServiceProvider;
use Spryker\Zed\ZedNavigation\Communication\Plugin\ServiceProvider\ZedNavigationServiceProvider;
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
            new SslServiceProvider(),
            new AuthBootstrapProvider(),
            new AclBootstrapProvider(),
            new TwigServiceProvider(),
            new SprykerTwigServiceProvider(),
            new EnvironmentInformationServiceProvider(),
            new GatewayServiceProviderPlugin(),
            new AssertionServiceProvider(),
            new UserServiceProvider(),
            new TwigMoneyServiceProvider(),
            new SubRequestServiceProvider(),
            new WebProfilerServiceProvider(),
            new ZedHstsServiceProvider(),
            new FormFactoryServiceProvider(),
            new TwigCurrencyServiceProvider(),
            new MessengerServiceProvider(),
            new ZedNavigationServiceProvider(),
            new MonitoringRequestTransactionServiceProvider(),
            new TranslationServiceProvider(),
            new DateTimeFormatterServiceProvider(),
            new GuiTwigExtensionServiceProvider(),
            new RedirectAfterLoginProvider(),
            new PropelServiceProvider(),
            new GuiTwigExtensionServiceProvider(),
            new EventBehaviorServiceProvider(),
        ];

        if (Environment::isDevelopment()) {
            array_unshift($providers, new AssertUrlConfigurationServiceProvider());
        }

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
            new SslServiceProvider(),
            new ServiceControllerServiceProvider(),
            new RoutingServiceProvider(),
            new ApiServiceProviderPlugin,
            new ApiRoutingServiceProvider(),
            new PropelServiceProvider(),
            new EventBehaviorServiceProvider(),
        ];

        if (Environment::isDevelopment()) {
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
            new PropelServiceProvider(),
            new RequestServiceProvider(),
            new SslServiceProvider(),
            new ServiceControllerServiceProvider(),
            new RoutingServiceProvider(),
            new MvcRoutingServiceProvider(),
            new SilexRoutingServiceProvider(),
            new GatewayServiceProviderPlugin(),
            new MonitoringRequestTransactionServiceProvider(),
            new HttpFragmentServiceProvider(),
            new SubRequestServiceProvider(),
            new TwigServiceProvider(),
            new SprykerTwigServiceProvider(),
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
            new PropelServiceProvider(),
            new RequestServiceProvider(),
            new SessionServiceProvider(),
            new SprykerSessionServiceProvider(),
            new SslServiceProvider(),
            new AuthBootstrapProvider(),
            new AclBootstrapProvider(),
            new ServiceControllerServiceProvider(),
            new RoutingServiceProvider(),
            new MvcRoutingServiceProvider(),
            new SilexRoutingServiceProvider(),
            new GatewayServiceProviderPlugin(),
            new MonitoringRequestTransactionServiceProvider(),
            new HttpFragmentServiceProvider(),
            new SubRequestServiceProvider(),
            new TwigServiceProvider(),
            new SprykerTwigServiceProvider(),
            new EventBehaviorServiceProvider(),
        ];
    }
}
