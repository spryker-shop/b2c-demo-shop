<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MessageBrokerTestMessageTransfer;
use PyzTest\Zed\MessageBroker\MessageBrokerBusinessTester;
use Ramsey\Uuid\Uuid;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageSenderPluginInterface;
use Symfony\Component\Messenger\Envelope;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group Business
 * @group SendMessageTest
 * Add your own group annotations below this line
 */
class SendMessageTest extends Unit
{
    /**
     * @var string
     */
    public const CHANNEL_NAME = 'channel';

    /**
     * @var string
     */
    protected const MESSAGE_BROKER_TRANSFER_VALUE = 'value';

    /**
     * @var \PyzTest\Zed\MessageBroker\MessageBrokerBusinessTester
     */
    protected MessageBrokerBusinessTester $tester;

    /**
     * @return void
     */
    public function testCheckAttributesBeforeSendingMessage(): void
    {
        // Arrange
        $messageSenderPlugin = $this->createMock(MessageSenderPluginInterface::class);

        $this->tester->setMessageToSenderChannelNameMap(MessageBrokerTestMessageTransfer::class, static::CHANNEL_NAME);
        $this->tester->setChannelToTransportMap(static::CHANNEL_NAME, $messageSenderPlugin->getTransportName());

        // Assert
        $messageSenderPlugin
            ->expects($this->once())
            ->method('send')
            ->willReturnCallback(function (Envelope $envelope) {
                /** @var \Generated\Shared\Transfer\MessageBrokerTestMessageTransfer $message */
                $message = $envelope->getMessage();

                $this->assertSame($message::class, MessageBrokerTestMessageTransfer::class);
                $this->assertSame($message->getKey(), static::MESSAGE_BROKER_TRANSFER_VALUE);

                $this->assertIsObject($message->getMessageAttributes());

                $this->assertSame($message->getMessageAttributes()->getTransferName(), $this->getTransferNameFromClass($message));
                $this->assertSame($message->getMessageAttributes()->getEvent(), $this->getTransferNameFromClass($message));

                $this->assertNotEmpty($message->getMessageAttributes()->getTimestamp());
                $this->assertNotEmpty($message->getMessageAttributes()->getCorrelationId());
                $this->assertTrue(Uuid::isValid($message->getMessageAttributes()->getCorrelationId()));

                $this->assertNotEmpty($message->getMessageAttributes()->getTransactionId());
                $this->assertTrue(Uuid::isValid($message->getMessageAttributes()->getTransactionId()));

                $this->assertNotEmpty($message->getMessageAttributes()->getSessionTrackingId());
                $this->assertTrue(Uuid::isValid($message->getMessageAttributes()->getSessionTrackingId()));

                $this->assertNotEmpty($message->getMessageAttributes()->getAuthorization());
                $this->assertStringContainsString('Bearer', $message->getMessageAttributes()->getAuthorization());

                $this->assertNotEmpty($message->getMessageAttributes()->getTenantIdentifier());
                $this->assertSame(
                    $message->getMessageAttributes()->getTenantIdentifier(),
                    $this->tester->getModuleConfig()->getTenantIdentifier(),
                );

                return $envelope;
            });

        $this->tester->setMessageSenderPlugins([$messageSenderPlugin]);

        $messageBrokerTestMessageTransfer = new MessageBrokerTestMessageTransfer();
        $messageBrokerTestMessageTransfer->setKey(static::MESSAGE_BROKER_TRANSFER_VALUE);

        // Act
        $this->tester->getMessageBrokerFacade()->sendMessage($messageBrokerTestMessageTransfer);
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $messageTransfer
     *
     * @return string
     */
    protected function getTransferNameFromClass(TransferInterface $messageTransfer): string
    {
        $messageName = get_class($messageTransfer);

        return str_replace(['Generated\Shared\Transfer\\', 'Transfer'], '', $messageName);
    }
}
