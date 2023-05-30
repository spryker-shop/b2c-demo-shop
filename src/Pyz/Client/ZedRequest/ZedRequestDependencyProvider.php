<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ZedRequest;

use Spryker\Client\Currency\Plugin\ZedRequestMetaDataProviderPlugin;
use Spryker\Client\Locale\Plugin\ZedRequest\LocaleMetaDataProviderPlugin;
use Spryker\Client\Store\Plugin\ZedRequest\StoreMetaDataProviderPlugin;
use Spryker\Client\ZedRequest\Plugin\AcceptEncodingHeaderExpanderPlugin;
use Spryker\Client\ZedRequest\Plugin\AuthTokenHeaderExpanderPlugin;
use Spryker\Client\ZedRequest\Plugin\RequestIdHeaderExpanderPlugin;
use Spryker\Client\ZedRequest\ZedRequestDependencyProvider as SprykerZedRequestDependencyProvider;

class ZedRequestDependencyProvider extends SprykerZedRequestDependencyProvider
{
    /**
     * @return array<string, \Spryker\Client\ZedRequestExtension\Dependency\Plugin\MetaDataProviderPluginInterface>
     */
    protected function getMetaDataProviderPlugins(): array
    {
        return [
            'currency' => new ZedRequestMetaDataProviderPlugin(),
            'store' => new StoreMetaDataProviderPlugin(),
            'locale' => new LocaleMetaDataProviderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Client\ZedRequestExtension\Dependency\Plugin\HeaderExpanderPluginInterface>
     */
    protected function getHeaderExpanderPlugins(): array
    {
        return [
            new AcceptEncodingHeaderExpanderPlugin(),
            new AuthTokenHeaderExpanderPlugin(),
            new RequestIdHeaderExpanderPlugin(),
        ];
    }
}
