<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget;

use Pyz\Yves\ContentProductSetWidget\Reader\ContentProductAbstractReader;
use Pyz\Yves\ContentProductSetWidget\Reader\ContentProductAbstractReaderInterface;
use Pyz\Yves\ContentProductSetWidget\Reader\ContentProductSetReader;
use Pyz\Yves\ContentProductSetWidget\Reader\ContentProductSetReaderInterface;
use Pyz\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunctionProvider;
use Spryker\Shared\Twig\TwigFunctionProvider;
use SprykerShop\Yves\ContentProductSetWidget\ContentProductSetWidgetFactory as SprykerContentProductSetWidgetFactory;
use Twig\Environment;
use Twig\TwigFunction;

class ContentProductSetWidgetFactory extends SprykerContentProductSetWidgetFactory
{
    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     *
     * @return \Twig\TwigFunction
     */
    public function createPyzContentProductSetTwigFunction(
        Environment $twig,
        string $localeName,
    ): TwigFunction {
        $functionProvider = $this->createPyzContentProductSetTwigFunctionProvider($twig, $localeName);

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
    public function createPyzContentProductSetTwigFunctionProvider(
        Environment $twig,
        string $localeName,
    ): TwigFunctionProvider {
        return new ContentProductSetTwigFunctionProvider(
            $twig,
            $localeName,
            $this->createPyzContentProductSetReader(),
            $this->createPyzContentProductAbstractReader(),
        );
    }

    /**
     * @return \Pyz\Yves\ContentProductSetWidget\Reader\ContentProductSetReaderInterface
     */
    public function createPyzContentProductSetReader(): ContentProductSetReaderInterface
    {
        return new ContentProductSetReader(
            $this->getContentProductSetClient(),
            $this->getProductSetStorageClient(),
        );
    }

    /**
     * @return \Pyz\Yves\ContentProductSetWidget\Reader\ContentProductAbstractReaderInterface
     */
    public function createPyzContentProductAbstractReader(): ContentProductAbstractReaderInterface
    {
        return new ContentProductAbstractReader(
            $this->getProductStorageClient(),
        );
    }
}
