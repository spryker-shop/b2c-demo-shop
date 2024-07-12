<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Log;

use Spryker\Zed\Log\Communication\Plugin\Handler\ExceptionStreamHandlerPlugin;
use Spryker\Zed\Log\Communication\Plugin\Handler\StreamHandlerPlugin;
use Spryker\Zed\Log\Communication\Plugin\Log\AuditLogMetaDataProcessorPlugin;
use Spryker\Zed\Log\Communication\Plugin\Log\AuditLogRequestProcessorPlugin;
use Spryker\Zed\Log\Communication\Plugin\Log\AuditLogTagFilterBufferedStreamHandlerPlugin;
use Spryker\Zed\Log\Communication\Plugin\Processor\EnvironmentProcessorPlugin;
use Spryker\Zed\Log\Communication\Plugin\Processor\GuzzleBodyProcessorPlugin;
use Spryker\Zed\Log\Communication\Plugin\Processor\PsrLogMessageProcessorPlugin;
use Spryker\Zed\Log\Communication\Plugin\Processor\RequestProcessorPlugin;
use Spryker\Zed\Log\Communication\Plugin\Processor\ResponseProcessorPlugin;
use Spryker\Zed\Log\Communication\Plugin\Processor\ServerProcessorPlugin;
use Spryker\Zed\Log\LogDependencyProvider as SprykerLogDependencyProvider;
use Spryker\Zed\Propel\Communication\Plugin\Log\EntityProcessorPlugin;
use Spryker\Zed\User\Communication\Plugin\Log\CurrentUserDataRequestProcessorPlugin;

class LogDependencyProvider extends SprykerLogDependencyProvider
{
    /**
     * @return array<\Spryker\Shared\Log\Dependency\Plugin\LogHandlerPluginInterface>
     */
    protected function getLogHandlers(): array
    {
        return [
            new StreamHandlerPlugin(),
            new ExceptionStreamHandlerPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Shared\Log\Dependency\Plugin\LogHandlerPluginInterface>
     */
    protected function getZedSecurityAuditLogHandlerPlugins(): array
    {
        return [
            new AuditLogTagFilterBufferedStreamHandlerPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\Log\Dependency\Plugin\LogProcessorPluginInterface>
     */
    protected function getLogProcessors(): array
    {
        return [
            new PsrLogMessageProcessorPlugin(),
            new EntityProcessorPlugin(),
            new EnvironmentProcessorPlugin(),
            new ServerProcessorPlugin(),
            new RequestProcessorPlugin(),
            new ResponseProcessorPlugin(),
            new GuzzleBodyProcessorPlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Shared\Log\Dependency\Plugin\LogProcessorPluginInterface>
     */
    protected function getZedSecurityAuditLogProcessorPlugins(): array
    {
        return [
            new PsrLogMessageProcessorPlugin(),
            new EnvironmentProcessorPlugin(),
            new ServerProcessorPlugin(),
            new AuditLogRequestProcessorPlugin(),
            new CurrentUserDataRequestProcessorPlugin(),
            new ResponseProcessorPlugin(),
            new AuditLogMetaDataProcessorPlugin(),
        ];
    }
}
