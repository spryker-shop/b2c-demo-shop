<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Queue;

use Generated\Shared\Transfer\RabbitMqConsumerOptionTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Event\EventConstants;
use Spryker\Shared\Log\LogConstants;
use Spryker\Shared\Queue\QueueConstants;
use Spryker\Zed\Queue\QueueConfig as SprykerQueueConfig;

class QueueConfig extends SprykerQueueConfig
{
    /**
     * @var string
     */
    public const PYZ_RABBITMQ = 'rabbitmq';

    /**
     * @return array<int>
     */
    public function getSignalsForGracefulWorkerShutdown(): array
    {
        return [
            static::SIGINT,
            static::SIGQUIT,
            static::SIGABRT,
            static::SIGTERM,
        ];
    }

    /**
     * @return array
     */
    protected function getQueueReceiverOptions(): array
    {
        return [
            QueueConstants::QUEUE_DEFAULT_RECEIVER => [
                static::PYZ_RABBITMQ => $this->getPyzRabbitMqQueueConsumerOptions(),
            ],
            EventConstants::EVENT_QUEUE => [
                static::PYZ_RABBITMQ => $this->getPyzRabbitMqQueueConsumerOptions(),
            ],
            Config::get(LogConstants::LOG_QUEUE_NAME) => [
                static::PYZ_RABBITMQ => $this->getPyzRabbitMqQueueConsumerOptions(),
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getMessageCheckOptions(): array
    {
        return [
            QueueConstants::QUEUE_WORKER_MESSAGE_CHECK_OPTION => [
                static::PYZ_RABBITMQ => $this->getPyzRabbitMqQueueMessageCheckOptions(),
            ],
        ];
    }

    /**
     * @return \Generated\Shared\Transfer\RabbitMqConsumerOptionTransfer
     */
    protected function getPyzRabbitMqQueueMessageCheckOptions(): RabbitMqConsumerOptionTransfer
    {
        $queueOptionTransfer = $this->getPyzRabbitMqQueueConsumerOptions();
        $queueOptionTransfer->setRequeueOnReject(true);

        return $queueOptionTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\RabbitMqConsumerOptionTransfer
     */
    protected function getPyzRabbitMqQueueConsumerOptions(): RabbitMqConsumerOptionTransfer
    {
        $queueOptionTransfer = new RabbitMqConsumerOptionTransfer();
        $queueOptionTransfer->setConsumerExclusive(false);
        $queueOptionTransfer->setNoWait(false);

        return $queueOptionTransfer;
    }
}
