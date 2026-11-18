<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Client\Captcha;

use Spryker\Client\Captcha\CaptchaDependencyProvider as SprykerCaptchaDependencyProvider;
use Spryker\Client\CaptchaExtension\Dependency\Plugin\CaptchaProviderPluginInterface;
use SprykerEco\Client\CaptchaAltcha\Plugin\Captcha\AltchaCaptchaProviderPlugin;

class CaptchaDependencyProvider extends SprykerCaptchaDependencyProvider
{
    protected function getCaptchaProviderPlugin(): ?CaptchaProviderPluginInterface
    {
        return new AltchaCaptchaProviderPlugin();
    }
}
