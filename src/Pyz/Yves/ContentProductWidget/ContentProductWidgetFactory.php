<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget;

use Pyz\Yves\ContentProductWidget\Reader\ContentProductAbstractReader;
use Pyz\Yves\ContentProductWidget\Reader\ContentProductAbstractReaderInterface;
use Pyz\Yves\ContentProductWidget\Twig\ContentProductAbstractListTwigFunctionProvider;
use Spryker\Client\ContentProduct\ContentProductClientInterface;
use Spryker\Client\ProductStorage\ProductStorageClientInterface;
use Spryker\Shared\Twig\TwigFunctionProvider;
use SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory as SprykerContentProductWidgetFactory;
use Twig\Environment;
use Twig\TwigFunction;

class ContentProductWidgetFactory extends SprykerContentProductWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Twig\TwigFunction
     */
    public function createPyzContentProductAbstractListTwigFunction(Environment $twig, string $localeName): TwigFunction
    {
        $functionProvider = $this->createPyzContentProductAbstractListTwigFunctionProvider($twig, $localeName);

        return new TwigFunction(
            $functionProvider->getFunctionName(),
            $functionProvider->getFunction(),
            $functionProvider->getOptions(),
        );
    }

    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Spryker\Shared\Twig\TwigFunctionProvider
     */
    public function createPyzContentProductAbstractListTwigFunctionProvider(Environment $twig, string $localeName): TwigFunctionProvider
    {
        return new ContentProductAbstractListTwigFunctionProvider(
            $twig,
            $localeName,
            $this->createPyzContentProductAbstractReader(),
        );
    }

    /**
     * @return \Pyz\Yves\ContentProductWidget\Reader\ContentProductAbstractReaderInterface
     */
    public function createPyzContentProductAbstractReader(): ContentProductAbstractReaderInterface
    {
        return new ContentProductAbstractReader(
            $this->getPyzContentProductClient(),
            $this->getPyzProductStorageClient(),
        );
    }

    /**
     * @return \Spryker\Client\ContentProduct\ContentProductClientInterface
     */
    public function getPyzContentProductClient(): ContentProductClientInterface
    {
        return $this->getProvidedDependency(ContentProductWidgetDependencyProvider::PYZ_CLIENT_CONTENT_PRODUCT);
    }

    /**
     * @return \Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    public function getPyzProductStorageClient(): ProductStorageClientInterface
    {
        return $this->getProvidedDependency(ContentProductWidgetDependencyProvider::PYZ_CLIENT_PRODUCT_STORAGE);
    }
}
