<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Log;

use Spryker\Yves\Customer\Plugin\Log\CurrentCustomerDataRequestProcessorPlugin;
use Spryker\Yves\Log\LogDependencyProvider as SprykerLogDependencyProvider;
use Spryker\Yves\Log\Plugin\Handler\ExceptionStreamHandlerPlugin;
use Spryker\Yves\Log\Plugin\Handler\StreamHandlerPlugin;
use Spryker\Yves\Log\Plugin\Log\AuditLogMetaDataProcessorPlugin;
use Spryker\Yves\Log\Plugin\Log\AuditLogRequestProcessorPlugin;
use Spryker\Yves\Log\Plugin\Log\AuditLogTagFilterBufferedStreamHandlerPlugin;
use Spryker\Yves\Log\Plugin\Processor\EnvironmentProcessorPlugin;
use Spryker\Yves\Log\Plugin\Processor\GuzzleBodyProcessorPlugin;
use Spryker\Yves\Log\Plugin\Processor\PsrLogMessageProcessorPlugin;
use Spryker\Yves\Log\Plugin\Processor\RequestProcessorPlugin;
use Spryker\Yves\Log\Plugin\Processor\ResponseProcessorPlugin;
use Spryker\Yves\Log\Plugin\Processor\ServerProcessorPlugin;
use SprykerShop\Yves\AgentPage\Plugin\Log\AgentCurrentRequestProcessorPlugin;

class LogDependencyProvider extends SprykerLogDependencyProvider
{
    /**
     * @return array<\Monolog\Handler\HandlerInterface>
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
    protected function getYvesSecurityAuditLogHandlerPlugins(): array
    {
        return [
            new AuditLogTagFilterBufferedStreamHandlerPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Shared\Log\Dependency\Plugin\LogProcessorPluginInterface>
     */
    protected function getProcessors(): array
    {
        return [
            new PsrLogMessageProcessorPlugin(),
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
    protected function getYvesSecurityAuditLogProcessorPlugins(): array
    {
        return [
            new PsrLogMessageProcessorPlugin(),
            new EnvironmentProcessorPlugin(),
            new ServerProcessorPlugin(),
            new AuditLogRequestProcessorPlugin(),
            new CurrentCustomerDataRequestProcessorPlugin(),
            new ResponseProcessorPlugin(),
            new AuditLogMetaDataProcessorPlugin(),
            new AgentCurrentRequestProcessorPlugin(),
        ];
    }
}
