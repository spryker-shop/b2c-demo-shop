<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\Captcha;

use Spryker\Yves\Captcha\CaptchaDependencyProvider as SprykerCaptchaDependencyProvider;
use SprykerShop\Yves\SecurityBlockerPage\Plugin\Captcha\SecurityBlockerLoginCaptchaRequirementPlugin;

class CaptchaDependencyProvider extends SprykerCaptchaDependencyProvider
{
    /**
     * @return list<\Spryker\Shared\CaptchaExtension\Dependency\Plugin\CaptchaRequirementPluginInterface>
     */
    protected function getCaptchaRequirementPlugins(): array
    {
        return [
            new SecurityBlockerLoginCaptchaRequirementPlugin(),
        ];
    }
}
