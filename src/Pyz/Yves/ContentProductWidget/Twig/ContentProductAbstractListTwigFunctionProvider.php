<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductWidget\Twig;

use Pyz\Yves\ContentProductWidget\Reader\ContentProductAbstractReaderInterface;
use Spryker\Client\ContentProduct\Exception\InvalidProductAbstractListTermException;
use Spryker\Shared\Twig\TwigFunctionProvider;
use Twig\Environment;

/**
 * @method \SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory getFactory()
 */
class ContentProductAbstractListTwigFunctionProvider extends TwigFunctionProvider
{
    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITH_BUTTON = 'slider-with-button';

    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_SLIDER = 'slider';

    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_SLIDER_NOT_INCLUDE_GROUP = 'slider-not-include-group';

    /**
     * @var string
     */
    protected const PYZ_FUNCTION_CONTENT_PRODUCT_ABSTRACT_LIST = 'content_product_abstract_list';

    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_BOTTOM_TITLE = 'bottom-title';

    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_TOP_TITLE = 'top-title';

    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $localeName;

    /**
     * @var \Pyz\Yves\ContentProductWidget\Reader\ContentProductAbstractReaderInterface
     */
    protected $contentProductAbstractReader;

    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     * @param \Pyz\Yves\ContentProductWidget\Reader\ContentProductAbstractReaderInterface $contentProductAbstractReader
     */
    public function __construct(
        Environment $twig,
        string $localeName,
        ContentProductAbstractReaderInterface $contentProductAbstractReader,
    ) {
        $this->twig = $twig;
        $this->localeName = $localeName;
        $this->contentProductAbstractReader = $contentProductAbstractReader;
    }

    /**
     * @return string
     */
    public function getFunctionName(): string
    {
        return static::PYZ_FUNCTION_CONTENT_PRODUCT_ABSTRACT_LIST;
    }

    /**
     * @return callable
     */
    public function getFunction(): callable
    {
        return function (string $contentKey, string $templateIdentifier): string {
            if (!isset($this->getPyzAvailableTemplates()[$templateIdentifier])) {
                return $this->getPyzMessageProductAbstractWrongTemplate($templateIdentifier);
            }

            try {
                $productAbstractViewCollection = $this->contentProductAbstractReader
                    ->getPyzProductAbstractCollection($contentKey, $this->localeName);
            } catch (InvalidProductAbstractListTermException $exception) {
                return $this->getPyzMessageProductAbstractWrongType($contentKey);
            }

            if ($productAbstractViewCollection === []) {
                return $this->getPyzMessageProductAbstractNotFound($contentKey);
            }

            return (string)$this->twig->render(
                $this->getPyzAvailableTemplates()[$templateIdentifier],
                [
                    'productAbstractViewCollection' => $productAbstractViewCollection,
                ],
            );
        };
    }

    /**
     * @return array
     */
    protected function getPyzAvailableTemplates(): array
    {
        return [
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_BOTTOM_TITLE => '@ContentProductWidget/views/cms-product-abstract-list/cms-product-abstract-list.twig',
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_TOP_TITLE => '@ContentProductWidget/views/cms-product-abstract-list-alternative/cms-product-abstract-list-alternative.twig',
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITH_BUTTON => '@ContentProductWidget/views/cms-product-abstract-and-button/cms-product-abstract-and-button.twig',
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_SLIDER => '@ContentProductWidget/views/cms-product-abstract/cms-product-abstract.twig',
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_SLIDER_NOT_INCLUDE_GROUP => '@ContentProductWidget/views/cms-product-abstract-not-include-group/cms-product-abstract-not-include-group.twig',
        ];
    }

    /**
     * @param string $contentKey
     *
     * @return string
     */
    protected function getPyzMessageProductAbstractNotFound(string $contentKey): string
    {
        return sprintf('<strong>Content product abstract list with content key "%s" not found.</strong>', $contentKey);
    }

    /**
     * @param string $templateIdentifier
     *
     * @return string
     */
    protected function getPyzMessageProductAbstractWrongTemplate(string $templateIdentifier): string
    {
        return sprintf('<strong>"%s" is not supported name of template.</strong>', $templateIdentifier);
    }

    /**
     * @param string $contentKey
     *
     * @return string
     */
    protected function getPyzMessageProductAbstractWrongType(string $contentKey): string
    {
        return sprintf('<strong>Content product abstract list widget could not be rendered because the content item with key "%s" is not an abstract product list.</strong>', $contentKey);
    }
}
