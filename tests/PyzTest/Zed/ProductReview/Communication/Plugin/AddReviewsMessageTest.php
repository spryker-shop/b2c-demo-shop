<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\ProductReview\Communication\Plugin;

use Codeception\Test\Unit;
use PyzTest\Zed\ProductReview\ProductReviewTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group ProductReview
 * @group Communication
 * @group Plugin
 * @group AddReviewsMessageTest
 * Add your own group annotations below this line
 */
class AddReviewsMessageTest extends Unit
{
    /**
     * @var \PyzTest\Zed\ProductReview\ProductReviewTester
     */
    protected ProductReviewTester $tester;

    /**
     * @return void
     */
    public function testAddReviewsMessageIsSuccessfullyHandled(): void
    {
        if ($this->tester->seeThatDynamicStoreEnabled()) {
            $this->tester->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => 'dev-DE']);

        $addReviewsTransfer = $this->tester->haveAddReviewTransferWithValidProductAndLocale();
        $reviewsTransfer = $addReviewsTransfer->getReviews()->getIterator()->current();

        // Act
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($addReviewsTransfer);
        $messageBrokerFacade->startWorker($this->tester->buildMessageBrokerWorkerConfigTransfer(['reviews'], 1));

        // Assert
        $this->tester->assertReviewExists($reviewsTransfer);
    }
}
