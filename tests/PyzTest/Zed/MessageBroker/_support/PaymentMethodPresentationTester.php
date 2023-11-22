<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PyzTest\Zed\MessageBroker;

use Codeception\Actor;
use Generated\Shared\DataBuilder\MessageAttributesBuilder;
use Generated\Shared\Transfer\PaymentMethodAddedTransfer;
use Generated\Shared\Transfer\PaymentMethodDeletedTransfer;
use Orm\Zed\Payment\Persistence\SpyPaymentMethodQuery;
use Orm\Zed\Payment\Persistence\SpyPaymentMethodStoreQuery;
use Ramsey\Uuid\Uuid;
use Spryker\Zed\Payment\Business\Generator\PaymentMethodKeyGenerator;
use Spryker\Zed\Payment\Dependency\Service\PaymentToUtilTextServiceBridge;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(\PyzTest\Zed\MessageBroker\PHPMD)
 */
class PaymentMethodPresentationTester extends Actor
{
    use _generated\PaymentMethodPresentationTesterActions {
        havePaymentMethodAddedTransfer as protected testerHavePaymentMethodAddedTransferAction;
        havePaymentMethodDeletedTransfer as protected testerHavePaymentMethodDeletedTransferAction;
    }

    /**
     * @param array<string, mixed> $seedData
     * @param array<string, mixed> $messageAttributesSeedData
     *
     * @return \Generated\Shared\Transfer\PaymentMethodAddedTransfer
     */
    public function havePaymentMethodAddedTransfer(
        array $seedData,
        array $messageAttributesSeedData = [],
    ): PaymentMethodAddedTransfer {
        return $this->testerHavePaymentMethodAddedTransferAction($seedData)
            ->setMessageAttributes(
                (new MessageAttributesBuilder($messageAttributesSeedData))->build(),
            );
    }

    /**
     * @param array<string, mixed> $seedData
     * @param array<string, mixed> $messageAttributesSeedData
     *
     * @return \Generated\Shared\Transfer\PaymentMethodDeletedTransfer
     */
    public function havePaymentMethodDeletedTransfer(
        array $seedData,
        array $messageAttributesSeedData = [],
    ): PaymentMethodDeletedTransfer {
        return $this->testerHavePaymentMethodDeletedTransferAction($seedData)
            ->setMessageAttributes(
                (new MessageAttributesBuilder($messageAttributesSeedData))->build(),
            );
    }

    /**
     * @param string $paymentProviderName
     * @param string $paymentMethodName
     *
     * @return string
     */
    public function generatePaymentMethodKey(
        string $paymentProviderName,
        string $paymentMethodName,
    ): string {
        $utilTextService = $this->getLocator()->utilText()->service();
        $paymentMethodKeyGenerator = new PaymentMethodKeyGenerator(
            new PaymentToUtilTextServiceBridge($utilTextService),
        );

        return $paymentMethodKeyGenerator->generate(
            $paymentProviderName,
            $paymentMethodName,
        );
    }

    /**
     * @param string $paymentMethodKey
     *
     * @return void
     */
    public function cleanupPaymentMethodByPaymentMethodKey(string $paymentMethodKey): void
    {
        $this->addCleanup(function () use ($paymentMethodKey): void {
            $paymentMethod = SpyPaymentMethodQuery::create()
                ->filterByPaymentMethodKey($paymentMethodKey)
                ->findOne();

            if ($paymentMethod === null) {
                return;
            }

            SpyPaymentMethodStoreQuery::create()
                ->filterByFkPaymentMethod($paymentMethod->getIdPaymentMethod())
                ->delete();

            $paymentMethod->delete();
        });
    }

    /**
     * @return string
     */
    protected function getUuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
