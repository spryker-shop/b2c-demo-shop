<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\PaymentMethod;

use Codeception\Actor;
use Generated\Shared\Transfer\MessageAttributesTransfer;
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
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(\PyzTest\Zed\PaymentMethod\PHPMD)
 */
class PaymentMethodPresentationTester extends Actor
{
    use _generated\PaymentMethodPresentationTesterActions;

    /**
     * @return bool
     */
    public function seeThatDynamicStoreEnabled(): bool
    {
        return $this->getLocator()->store()->facade()->isDynamicStoreEnabled();
    }

    /**
     * @param string $storeReference
     * @param string $paymentMethodName
     * @param string $providerName
     * @param string $authorizationEndpoint
     *
     * @return \Generated\Shared\Transfer\PaymentMethodAddedTransfer
     */
    public function havePaymentMethodAddedTransfer(
        string $storeReference,
        string $paymentMethodName,
        string $providerName,
        string $authorizationEndpoint = '',
    ): PaymentMethodAddedTransfer {
        return (new PaymentMethodAddedTransfer())
            ->setName($paymentMethodName)
            ->setProviderName($providerName)
            ->setPaymentAuthorizationEndpoint($authorizationEndpoint)
            ->setMessageAttributes(
                (new MessageAttributesTransfer())
                    ->setEmitter($this->getUuid())
                    ->setStoreReference($storeReference),
            );
    }

    /**
     * @param string $storeReference
     * @param string $paymentMethodName
     * @param string $providerName
     * @param string $authorizationEndpoint
     *
     * @return \Generated\Shared\Transfer\PaymentMethodDeletedTransfer
     */
    public function havePaymentMethodDeletedTransfer(
        string $storeReference,
        string $paymentMethodName,
        string $providerName,
        string $authorizationEndpoint = '',
    ): PaymentMethodDeletedTransfer {
        return (new PaymentMethodDeletedTransfer())
            ->setName($paymentMethodName)
            ->setProviderName($providerName)
            ->setPaymentAuthorizationEndpoint($authorizationEndpoint)
            ->setMessageAttributes(
                (new MessageAttributesTransfer())
                    ->setEmitter($this->getUuid())
                    ->setStoreReference($storeReference),
            );
    }

    /**
     * @param string $paymentProviderName
     * @param string $paymentMethodName
     * @param string $storeName
     *
     * @return string
     */
    public function generatePaymentMethodKey(
        string $paymentProviderName,
        string $paymentMethodName,
        string $storeName,
    ): string {
        $utilTextService = $this->getLocator()->utilText()->service();
        $paymentMethodKeyGenerator = new PaymentMethodKeyGenerator(
            new PaymentToUtilTextServiceBridge($utilTextService),
        );

        return $paymentMethodKeyGenerator->generatePaymentMethodKey(
            $paymentProviderName,
            $paymentMethodName,
            $storeName,
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
