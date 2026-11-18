<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Gui;

use Spryker\Zed\Gui\GuiConfig as SprykerGuiConfig;

class GuiConfig extends SprykerGuiConfig
{
    /**
     * @return array<string>
     */
    public function getDefaultTemplateFileNames(): array
    {
        return array_merge(parent::getDefaultTemplateFileNames(), [
            '@Captcha/Form/Type/captcha-full-width.twig',
        ]);
    }
}
