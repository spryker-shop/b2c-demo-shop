<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ShopApplication;

use SprykerShop\Yves\ShopApplication\ShopApplicationConfig as SprykerShopApplicationConfig;

class ShopApplicationConfig extends SprykerShopApplicationConfig
{
    /**
     * @return array<string>
     */
    public function getFormThemes(): array
    {
        return array_merge(parent::getFormThemes(), [
            '@Captcha/resources/form/captcha-full-width.twig',
        ]);
    }
}
