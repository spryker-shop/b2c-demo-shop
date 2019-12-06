<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Validator;

use Spryker\Zed\Security\Communication\Plugin\Validator\UserPasswordValidatorConstraintPlugin;
use Spryker\Zed\Translator\Communication\Plugin\Validator\TranslatorValidatorPlugin;
use Spryker\Zed\Validator\Communication\Plugin\Validator\ConstraintFactoryValidatorPlugin;
use Spryker\Zed\Validator\Communication\Plugin\Validator\MetadataFactoryValidatorPlugin;
use Spryker\Zed\Validator\ValidatorDependencyProvider as SprykerValidatorDependencyProvider;

class ValidatorDependencyProvider extends SprykerValidatorDependencyProvider
{
    /**
     * @return \Spryker\Shared\ValidatorExtension\Dependency\Plugin\ValidatorPluginInterface[]
     */
    protected function getValidatorPlugins(): array
    {
        return [
            new MetadataFactoryValidatorPlugin(),
            new ConstraintFactoryValidatorPlugin(),
            new TranslatorValidatorPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\ValidatorExtension\Dependency\Plugin\ConstraintPluginInterface[]
     */
    protected function getConstraintPlugins(): array
    {
        return [
            new UserPasswordValidatorConstraintPlugin(),
        ];
    }
}
