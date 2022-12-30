<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\QuoteRequestsRestApi;

use Spryker\Glue\ConfigurableBundlesRestApi\Plugin\QuoteRequestsRestApi\ConfiguredBundleRestQuoteRequestAttributesExpanderPlugin;
use Spryker\Glue\DiscountsRestApi\Plugin\QuoteRequestsRestApi\DiscountsRestQuoteRequestAttributesExpanderPlugin;
use Spryker\Glue\MerchantProductOffersRestApi\Plugin\QuoteRequestsRestApi\MerchantProductOffersRestQuoteRequestAttributesExpanderPlugin;
use Spryker\Glue\QuoteRequestsRestApi\QuoteRequestsRestApiDependencyProvider as SprykerQuoteRequestsRestApiDependencyProvider;

class QuoteRequestsRestApiDependencyProvider extends SprykerQuoteRequestsRestApiDependencyProvider
{
    /**
     * @return \Spryker\Glue\QuoteRequestsRestApiExtension\Dependency\Plugin\RestQuoteRequestAttributesExpanderPluginInterface[]
     */
    protected function getRestQuoteRequestAttributesExpanderPlugins() : array
    {
        return [
            new ConfiguredBundleRestQuoteRequestAttributesExpanderPlugin(),
            new DiscountsRestQuoteRequestAttributesExpanderPlugin(),
            new MerchantProductOffersRestQuoteRequestAttributesExpanderPlugin(),
        ];
    }
}