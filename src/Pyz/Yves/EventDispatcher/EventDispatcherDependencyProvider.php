<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\EventDispatcher;

use Spryker\Shared\Http\Plugin\EventDispatcher\ResponseListenerEventDispatcherPlugin;
use Spryker\Yves\Application\Communication\Plugin\EventDispatcher\HeadersSecurityEventDispatcherPlugin;
use Spryker\Yves\EventDispatcher\EventDispatcherDependencyProvider as SprykerEventDispatcherDependencyProvider;
use Spryker\Yves\Http\Plugin\EventDispatcher\CacheControlHeaderEventDispatcherPlugin;
use Spryker\Yves\Http\Plugin\EventDispatcher\CookieEventDispatcherPlugin;
use Spryker\Yves\Http\Plugin\EventDispatcher\EnvironmentInfoHeaderEventDispatcherPlugin;
use Spryker\Yves\Http\Plugin\EventDispatcher\FragmentEventDispatcherPlugin;
use Spryker\Yves\Http\Plugin\EventDispatcher\HstsHeaderEventDispatcher;
use Spryker\Yves\Kernel\Plugin\EventDispatcher\AutoloaderCacheEventDispatcherPlugin;
use Spryker\Yves\Kernel\Plugin\EventDispatcher\RedirectUrlValidationEventDispatcherPlugin;
use Spryker\Yves\Locale\Plugin\EventDispatcher\LocaleEventDispatcherPlugin;
use Spryker\Yves\Monitoring\Plugin\EventDispatcher\MonitoringRequestTransactionEventDispatcherPlugin;
use Spryker\Yves\Profiler\Plugin\EventDispatcher\ProfilerRequestEventDispatcherPlugin;
use Spryker\Yves\Router\Plugin\EventDispatcher\RouterListenerEventDispatcherPlugin;
use Spryker\Yves\Router\Plugin\EventDispatcher\RouterLocaleEventDispatcherPlugin;
use Spryker\Yves\Router\Plugin\EventDispatcher\RouterSslRedirectEventDispatcherPlugin;
use Spryker\Yves\Session\Plugin\EventDispatcher\SaveSessionEventDispatcherPlugin;
use Spryker\Yves\Session\Plugin\EventDispatcher\SessionEventDispatcherPlugin;
use Spryker\Yves\Storage\Plugin\EventDispatcher\StorageCacheEventDispatcherPlugin;
use SprykerShop\Yves\ErrorPage\Plugin\EventDispatcher\ErrorPageEventDispatcherPlugin;
use SprykerShop\Yves\SecurityBlockerPage\Plugin\EventDispatcher\SecurityBlockerAgentEventDispatcherPlugin;
use SprykerShop\Yves\SecurityBlockerPage\Plugin\EventDispatcher\SecurityBlockerCustomerEventDispatcherPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\EventDispatcher\LastVisitCookieEventDispatcherPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\EventDispatcher\ShopApplicationEventDispatcherPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\EventDispatcher\ShopApplicationExceptionEventDispatcherPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\EventDispatcher\ShopApplicationFilterControllerEventDispatcherPlugin;

class EventDispatcherDependencyProvider extends SprykerEventDispatcherDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface>
     */
    protected function getEventDispatcherPlugins(): array
    {
        $plugins = [
            new ErrorPageEventDispatcherPlugin(),
            new HeadersSecurityEventDispatcherPlugin(),
            new LocaleEventDispatcherPlugin(),
            new RouterLocaleEventDispatcherPlugin(),
            new ShopApplicationEventDispatcherPlugin(),
            new ShopApplicationFilterControllerEventDispatcherPlugin(),
            new ShopApplicationExceptionEventDispatcherPlugin(),
            new LastVisitCookieEventDispatcherPlugin(),
            new RouterListenerEventDispatcherPlugin(),
            new RouterSslRedirectEventDispatcherPlugin(),
            new CookieEventDispatcherPlugin(),
            new FragmentEventDispatcherPlugin(),
            new CacheControlHeaderEventDispatcherPlugin(),
            new HstsHeaderEventDispatcher(),
            new StorageCacheEventDispatcherPlugin(),
            new MonitoringRequestTransactionEventDispatcherPlugin(),
            new AutoloaderCacheEventDispatcherPlugin(),
            new SessionEventDispatcherPlugin(),
            new SaveSessionEventDispatcherPlugin(),
            new RedirectUrlValidationEventDispatcherPlugin(),
            new ResponseListenerEventDispatcherPlugin(),
            new SecurityBlockerCustomerEventDispatcherPlugin(),
            new SecurityBlockerAgentEventDispatcherPlugin(),
            new EnvironmentInfoHeaderEventDispatcherPlugin(),
        ];

        if (class_exists(ProfilerRequestEventDispatcherPlugin::class)) {
            $plugins[] = new ProfilerRequestEventDispatcherPlugin();
        }

        return $plugins;
    }
}
