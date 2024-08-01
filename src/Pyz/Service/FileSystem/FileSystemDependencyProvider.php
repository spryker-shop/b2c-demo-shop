<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Service\FileSystem;

use Spryker\Service\FileSystem\FileSystemDependencyProvider as SprykerFileSystemDependencyProvider;
use Spryker\Service\FileSystemExtension\Dependency\Plugin\FileSystemReaderPluginInterface;
use Spryker\Service\FileSystemExtension\Dependency\Plugin\FileSystemStreamPluginInterface;
use Spryker\Service\FileSystemExtension\Dependency\Plugin\FileSystemWriterPluginInterface;
use Spryker\Service\Flysystem\Plugin\FileSystem\FileSystemReaderPlugin;
use Spryker\Service\Flysystem\Plugin\FileSystem\FileSystemStreamPlugin;
use Spryker\Service\Flysystem\Plugin\FileSystem\FileSystemWriterPlugin;

class FileSystemDependencyProvider extends SprykerFileSystemDependencyProvider
{
    /**
     * @return \Spryker\Service\FileSystemExtension\Dependency\Plugin\FileSystemReaderPluginInterface
     */
    protected function getFileSystemReaderPlugin(): FileSystemReaderPluginInterface
    {
        return new FileSystemReaderPlugin();
    }

    /**
     * @return \Spryker\Service\FileSystemExtension\Dependency\Plugin\FileSystemStreamPluginInterface
     */
    protected function getFileSystemStreamPlugin(): FileSystemStreamPluginInterface
    {
        return new FileSystemStreamPlugin();
    }

    /**
     * @return \Spryker\Service\FileSystemExtension\Dependency\Plugin\FileSystemWriterPluginInterface
     */
    protected function getFileSystemWriterPlugin(): FileSystemWriterPluginInterface
    {
        return new FileSystemWriterPlugin();
    }
}
