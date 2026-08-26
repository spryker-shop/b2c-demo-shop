<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\MessageBroker;

use Codeception\Actor;
use Generated\Shared\DataBuilder\ConfigureTaxAppBuilder;
use Generated\Shared\DataBuilder\DeleteTaxAppBuilder;
use Generated\Shared\Transfer\ConfigureTaxAppTransfer;
use Generated\Shared\Transfer\DeleteTaxAppTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Generated\Shared\Transfer\TaxAppApiUrlsTransfer;
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
class TaxAppCommunicationTester extends Actor
{
    use _generated\TaxAppCommunicationTesterActions;

    public function assertTaxAppConfigIsSavedCorrectlyForStore(StoreTransfer $storeTransfer, ConfigureTaxAppTransfer $configureTaxAppTransfer): void
    {
        $taxAppConfigEntity = $this->findTaxAppConfigEntity($storeTransfer, $configureTaxAppTransfer->getVendorCode());

        $taxAppConfigApiUrlsTransfer = (new TaxAppApiUrlsTransfer())->fromArray(json_decode($taxAppConfigEntity->getApiUrls(), true));

        $this->assertEquals($taxAppConfigApiUrlsTransfer->getRefundsUrl(), $configureTaxAppTransfer->getApiUrlsOrFail()->getRefundsUrlOrFail());
        $this->assertEquals($taxAppConfigApiUrlsTransfer->getQuotationUrl(), $configureTaxAppTransfer->getApiUrlsOrFail()->getQuotationUrlOrFail());
        $this->assertEquals($taxAppConfigEntity->getVendorCode(), $configureTaxAppTransfer->getVendorCode());
        $this->assertEquals($taxAppConfigEntity->getApplicationId(), $configureTaxAppTransfer->getMessageAttributesOrFail()->getActorIdOrFail());
        $this->assertEquals($taxAppConfigEntity->getIsActive(), $configureTaxAppTransfer->getIsActive());
    }

    public function assertTaxAppConfigIsRemovedForStore(StoreTransfer $storeTransfer, DeleteTaxAppTransfer $deleteTaxAppTransfer): void
    {
        $taxAppConfigEntity = $this->findTaxAppConfigEntity($storeTransfer, $deleteTaxAppTransfer->getVendorCode());

        $this->assertNull($taxAppConfigEntity);
    }

    public function buildConfigureTaxAppTransfer(array $messageAttributesSeed = [], array $configureTaxAppSeed = []): ConfigureTaxAppTransfer
    {
        return (new ConfigureTaxAppBuilder())->seed($configureTaxAppSeed)->withApiUrls()
            ->withMessageAttributes($messageAttributesSeed)
            ->build();
    }

    public function buildDeleteTaxAppTransfer(array $messageAttributesSeed = [], array $configureTaxAppSeed = []): DeleteTaxAppTransfer
    {
        return (new DeleteTaxAppBuilder())->seed($configureTaxAppSeed)
            ->withMessageAttributes($messageAttributesSeed)
            ->build();
    }

    public function removeTaxAppConfigForStore(StoreTransfer $storeTransfer): void
    {
        (new SpyTaxAppConfigQuery())
            ->filterByFkStore($storeTransfer->getIdStore())
            ->delete();
    }

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

    protected function findTaxAppConfigEntity(StoreTransfer $storeTransfer, string $vendorCode): ?SpyTaxAppConfig
    {
        return (new SpyTaxAppConfigQuery())
            ->filterByFkStore($storeTransfer->getIdStore())
            ->filterByVendorCode($vendorCode)
            ->findOne();
    }
}
