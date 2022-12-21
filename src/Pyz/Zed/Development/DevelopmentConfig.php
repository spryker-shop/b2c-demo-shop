<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Development;

use Spryker\Zed\Development\DevelopmentConfig as SprykerDevelopmentConfig;

class DevelopmentConfig extends SprykerDevelopmentConfig
{
    /**
     * @return string
     */
    public function getCodingStandard(): string
    {
        return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'phpcs.xml';
    }

    /**
     * @param string $namespace
     *
     * @return string|null
     */
    public function getPathToInternalNamespace(string $namespace): ?string
    {
        $pathToSprykerRoot = $this->checkPathToSprykerRoot($namespace);
        if ($pathToSprykerRoot) {
            return $pathToSprykerRoot;
        }

        if (array_key_exists($namespace, $this->getPathsToInternalNamespace())) {
            $mergedInternalNamespacesToPathMapping =
                static::INTERNAL_NAMESPACES_TO_PATH_MAPPING + parent::INTERNAL_NAMESPACES_TO_PATH_MAPPING;

            return $mergedInternalNamespacesToPathMapping[$namespace];
        }

        return null;
    }

    /**
     * @return array<string>
     */
    public function getPathsToInternalNamespace(): array
    {
        $pathToSprykerRoot = $this->checkPathToSprykerRoot(static::NAMESPACE_SPRYKER);
        $sprykerNamespacePath = $pathToSprykerRoot ? [static::NAMESPACE_SPRYKER => $pathToSprykerRoot] : [];

        return $sprykerNamespacePath + static::INTERNAL_NAMESPACES_TO_PATH_MAPPING + parent::INTERNAL_NAMESPACES_TO_PATH_MAPPING;
    }
}
