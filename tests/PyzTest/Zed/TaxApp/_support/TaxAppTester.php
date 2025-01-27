<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\TaxApp;

use Codeception\Actor;
use Generated\Shared\DataBuilder\ConfigureTaxAppBuilder;
use Generated\Shared\DataBuilder\DeleteTaxAppBuilder;
use Generated\Shared\Transfer\ConfigureTaxAppTransfer;
use Generated\Shared\Transfer\DeleteTaxAppTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\TaxApp\Persistence\SpyTaxAppConfig;
use Orm\Zed\TaxApp\Persistence\SpyTaxAppConfigQuery;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

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
 * @method void pause()
 *
 * @SuppressWarnings(\PyzTest\Zed\TaxApp\PHPMD)
 */
class TaxAppTester extends Actor
{
    use _generated\TaxAppTesterActions;

    /**
     * @return bool
     */
    public function seeThatDynamicStoreEnabled(): bool
    {
        return $this->getLocator()->store()->facade()->isDynamicStoreEnabled();
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return void
     */
    public function assertTaxAppConfigExistsForStore(StoreTransfer $storeTransfer): void
    {
        $taxAppConfigEntity = $this->getTaxAppConfigEntity($storeTransfer);

        $this->assertNotNull($taxAppConfigEntity);
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return void
     */
    public function assertTaxAppConfigIsRemovedForStore(StoreTransfer $storeTransfer): void
    {
        $taxAppConfigEntity = $this->getTaxAppConfigEntity($storeTransfer);

        $this->assertNull($taxAppConfigEntity);
    }

    /**
     * @param array<mixed> $messageAttributeSeedData
     *
     * @return \Generated\Shared\Transfer\ConfigureTaxAppTransfer
     */
    public function buildConfigureTaxAppTransfer(array $messageAttributeSeedData = []): ConfigureTaxAppTransfer
    {
        return (new ConfigureTaxAppBuilder())
            ->withMessageAttributes($messageAttributeSeedData)
            ->withApiUrls()
            ->build();
    }

    /**
     * @param array<mixed> $messageAttributeSeedData
     *
     * @return \Generated\Shared\Transfer\DeleteTaxAppTransfer
     */
    public function buildDeleteTaxAppTransfer(array $messageAttributeSeedData = []): DeleteTaxAppTransfer
    {
        return (new DeleteTaxAppBuilder())
            ->withMessageAttributes($messageAttributeSeedData)
            ->build();
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return void
     */
    public function removeTaxAppConfigForStore(StoreTransfer $storeTransfer): void
    {
        (new SpyTaxAppConfigQuery())
            ->filterByFkStore($storeTransfer->getIdStore())
            ->delete();
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $configureTaxAppMessage
     *
     * @return void
     */
    public function handleTaxAppMessage(TransferInterface $configureTaxAppMessage): void
    {
        $channelName = 'tax-commands';
        $this->setupMessageBroker($configureTaxAppMessage::class, $channelName);
        $this->setupMessageBrokerPlugins();
        $messageBrokerFacade = $this->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($configureTaxAppMessage);
        $messageBrokerFacade->startWorker(
            $this->buildMessageBrokerWorkerConfigTransfer([$channelName], 1),
        );
        $this->resetInMemoryMessages();
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return \Orm\Zed\TaxApp\Persistence\SpyTaxAppConfig|null
     */
    protected function getTaxAppConfigEntity(StoreTransfer $storeTransfer): ?SpyTaxAppConfig
    {
        return (new SpyTaxAppConfigQuery())
            ->filterByFkStore($storeTransfer->getIdStore())
            ->findOne();
    }
}
