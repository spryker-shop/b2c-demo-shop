<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget;

use SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetConfig as SprykerProductReviewWidgetConfig;

class ProductReviewWidgetConfig extends SprykerProductReviewWidgetConfig
{
    /**
     * @var string
     */
    public const GLOSSARY_KEY_INVALID_RATING_VALIDATION_MESSAGE = 'product_review.error.invalid_rating';
}
