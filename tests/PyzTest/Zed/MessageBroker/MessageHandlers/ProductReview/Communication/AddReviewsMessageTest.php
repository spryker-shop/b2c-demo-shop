<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\ProductReview\Communication;

use Codeception\Test\Unit;
use PyzTest\Zed\MessageBroker\ProductReviewCommunicationTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group MessageHandlers
 * @group ProductReview
 * @group Communication
 * @group AddReviewsMessageTest
 * Add your own group annotations below this line
 */
class AddReviewsMessageTest extends Unit
{
    /**
     * @var \PyzTest\Zed\MessageBroker\ProductReviewCommunicationTester
     */
    protected ProductReviewCommunicationTester $tester;

    /**
     * @return void
     */
    public function testAddReviewsMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $channelName = 'product-review-commands';
        $addReviewsTransfer = $this->tester->haveAddReviewTransferWithValidProductAndLocale();

        $reviewsTransfer = $addReviewsTransfer->getReviews()->getIterator()->current();

        // Act
        $this->tester->setupMessageBroker($addReviewsTransfer::class, $channelName);
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($addReviewsTransfer);
        $messageBrokerFacade->startWorker($this->tester->buildMessageBrokerWorkerConfigTransfer([$channelName], 1));

        // Assert
        $this->tester->assertReviewExists($reviewsTransfer);
    }
}
