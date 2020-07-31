<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Form;

use Spryker\Zed\Form\Communication\Plugin\Form\CsrfFormPlugin;
use Spryker\Zed\Form\FormDependencyProvider as SprykerFormDependencyProvider;
use Spryker\Zed\Gui\Communication\Plugin\Form\NoValidateFormTypeExtensionFormPlugin;
use Spryker\Zed\Gui\Communication\Plugin\Form\SanitizeXssTypeExtensionFormPlugin;
use Spryker\Zed\Http\Communication\Pluign\Form\HttpFoundationFormPlugin;
use Spryker\Zed\Validator\Communication\Plugin\Form\ValidatorFormPlugin;
use Spryker\Zed\WebProfiler\Communication\Plugin\Form\WebProfilerFormPlugin;

class FormDependencyProvider extends SprykerFormDependencyProvider
{
    /**
     * @return \Spryker\Shared\FormExtension\Dependency\Plugin\FormPluginInterface[]
     */
    protected function getFormPlugins(): array
    {
        $plugins = [
            new ValidatorFormPlugin(),
            new HttpFoundationFormPlugin(),
            new CsrfFormPlugin(),
            new NoValidateFormTypeExtensionFormPlugin(),
            new SanitizeXssTypeExtensionFormPlugin(),
        ];

        if (class_exists(WebProfilerFormPlugin::class)) {
            $plugins[] = new WebProfilerFormPlugin();
        }

        return $plugins;
    }
}
