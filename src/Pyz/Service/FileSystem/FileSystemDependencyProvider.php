<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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
    protected function getFileSystemReaderPlugin(): FileSystemReaderPluginInterface
    {
        return new FileSystemReaderPlugin();
    }

    protected function getFileSystemStreamPlugin(): FileSystemStreamPluginInterface
    {
        return new FileSystemStreamPlugin();
    }

    protected function getFileSystemWriterPlugin(): FileSystemWriterPluginInterface
    {
        return new FileSystemWriterPlugin();
    }
}
