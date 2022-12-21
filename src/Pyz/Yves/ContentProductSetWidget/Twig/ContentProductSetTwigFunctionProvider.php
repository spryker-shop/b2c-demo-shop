<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContentProductSetWidget\Twig;

use Pyz\Yves\ContentProductSetWidget\Reader\ContentProductAbstractReaderInterface;
use Pyz\Yves\ContentProductSetWidget\Reader\ContentProductSetReaderInterface;
use Spryker\Client\ContentProductSet\Exception\InvalidProductSetTermException;
use Spryker\Shared\Twig\TwigFunctionProvider;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

/**
 * @method \SprykerShop\Yves\ContentProductWidget\ContentProductWidgetFactory getFactory()
 */
class ContentProductSetTwigFunctionProvider extends TwigFunctionProvider
{
    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART = 'add-to-cart';

    /**
     * @var string
     */
    protected const PYZ_FUNCTION_CONTENT_PRODUCT_SET = 'content_product_set';

    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_CART_BUTTON_TOP = 'cart-button-top';

    /**
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_CART_BUTTON_BOTTOM = 'cart-button-btm';

    /**
     * @var string
     */
    protected const PYZ_PARAM_ATTRIBUTE = 'attributes';

    /**
     * @deprecated Use {@link \SprykerShop\Yves\ContentProductSetWidget\Twig\ContentProductSetTwigFunctionProvider::WIDGET_TEMPLATE_IDENTIFIER_CART_BUTTON_TOP} instead.
     *
     * @var string
     */
    protected const PYZ_WIDGET_TEMPLATE_IDENTIFIER_DEFAULT = 'default';

    /**
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $localeName;

    /**
     * @var \Pyz\Yves\ContentProductSetWidget\Reader\ContentProductSetReaderInterface
     */
    protected $contentProductSetReader;

    /**
     * @var \Pyz\Yves\ContentProductSetWidget\Reader\ContentProductAbstractReaderInterface
     */
    protected $contentProductAbstractReader;

    /**
     * @param \Twig\Environment $twig
     * @param string $localeName
     * @param \Pyz\Yves\ContentProductSetWidget\Reader\ContentProductSetReaderInterface $contentProductSetReader
     * @param \Pyz\Yves\ContentProductSetWidget\Reader\ContentProductAbstractReaderInterface $contentProductAbstractReader
     */
    public function __construct(
        Environment $twig,
        string $localeName,
        ContentProductSetReaderInterface $contentProductSetReader,
        ContentProductAbstractReaderInterface $contentProductAbstractReader,
    ) {
        $this->twig = $twig;
        $this->localeName = $localeName;
        $this->contentProductSetReader = $contentProductSetReader;
        $this->contentProductAbstractReader = $contentProductAbstractReader;
    }

    /**
     * @return string
     */
    public function getFunctionName(): string
    {
        return static::PYZ_FUNCTION_CONTENT_PRODUCT_SET;
    }

    /**
     * @return callable
     */
    public function getFunction(): callable
    {
        return function (array $context, string $contentKey, string $templateIdentifier): string {
            if (!isset($this->getPyzAvailableTemplates()[$templateIdentifier])) {
                return $this->getPyzMessageProductSetWrongTemplate($templateIdentifier);
            }

            try {
                $productSetDataStorageTransfer = $this->contentProductSetReader
                    ->findProductSet($contentKey, $this->localeName);
            } catch (InvalidProductSetTermException $exception) {
                return $this->getPyzMessageProductSetWrongType($contentKey);
            }

            if (!$productSetDataStorageTransfer) {
                return $this->getPyzMessageProductSetNotFound($contentKey);
            }

            /** @var array $selectedAttributes */
            $selectedAttributes = $this->getPyzRequest($context)->query->get(static::PYZ_PARAM_ATTRIBUTE) ?: [];
            $productAbstractViewCollection = $this->contentProductAbstractReader
                ->findProductAbstractCollection($productSetDataStorageTransfer, $selectedAttributes, $this->localeName);

            return (string)$this->twig->render(
                $this->getPyzAvailableTemplates()[$templateIdentifier],
                [
                    'productSet' => $productSetDataStorageTransfer,
                    'productViews' => $productAbstractViewCollection,
                ],
            );
        };
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [
            'needs_context' => true,
            'is_safe' => ['html'],
        ];
    }

    /**
     * @return array<string>
     */
    protected function getPyzAvailableTemplates(): array
    {
        return [
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_DEFAULT => '@ContentProductSetWidget/views/content-product-set/content-product-set.twig',
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_CART_BUTTON_TOP => '@ContentProductSetWidget/views/content-product-set/content-product-set.twig',
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_CART_BUTTON_BOTTOM => '@ContentProductSetWidget/views/content-product-set-alternative/content-product-set-alternative.twig',
            static::PYZ_WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART => '@ContentProductSetWidget/views/add-to-cart/add-to-cart.twig',
        ];
    }

    /**
     * @param string $contentKey
     *
     * @return string
     */
    protected function getPyzMessageProductSetNotFound(string $contentKey): string
    {
        return sprintf('<strong>Content product set with content key "%s" not found.</strong>', $contentKey);
    }

    /**
     * @param string $templateIdentifier
     *
     * @return string
     */
    protected function getPyzMessageProductSetWrongTemplate(string $templateIdentifier): string
    {
        return sprintf('<strong>"%s" is not supported name of template.</strong>', $templateIdentifier);
    }

    /**
     * @param string $contentKey
     *
     * @return string
     */
    protected function getPyzMessageProductSetWrongType(string $contentKey): string
    {
        return sprintf('<strong>Content product set widget could not be rendered because the content item with key "%s" is not a product set.</strong>', $contentKey);
    }

    /**
     * @param array $context
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getPyzRequest(array $context): Request
    {
        return $context['app']['request'];
    }
}
