<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\ConfigureTaxAppTransfer $configureTaxAppTransfer
     *
     * @return void
     */
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

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param \Generated\Shared\Transfer\DeleteTaxAppTransfer $deleteTaxAppTransfer
     *
     * @return void
     */
    public function assertTaxAppConfigIsRemovedForStore(StoreTransfer $storeTransfer, DeleteTaxAppTransfer $deleteTaxAppTransfer): void
    {
        $taxAppConfigEntity = $this->findTaxAppConfigEntity($storeTransfer, $deleteTaxAppTransfer->getVendorCode());

        $this->assertNull($taxAppConfigEntity);
    }

    /**
     * @param array $messageAttributesSeed
     * @param array $configureTaxAppSeed
     *
     * @return \Generated\Shared\Transfer\ConfigureTaxAppTransfer
     */
    public function buildConfigureTaxAppTransfer(array $messageAttributesSeed = [], array $configureTaxAppSeed = []): ConfigureTaxAppTransfer
    {
        return (new ConfigureTaxAppBuilder())->seed($configureTaxAppSeed)->withApiUrls()
            ->withMessageAttributes($messageAttributesSeed)
            ->build();
    }

    /**
     * @param array $messageAttributesSeed
     * @param array $configureTaxAppSeed
     *
     * @return \Generated\Shared\Transfer\DeleteTaxAppTransfer
     */
    public function buildDeleteTaxAppTransfer(array $messageAttributesSeed = [], array $configureTaxAppSeed = []): DeleteTaxAppTransfer
    {
        return (new DeleteTaxAppBuilder())->seed($configureTaxAppSeed)
            ->withMessageAttributes($messageAttributesSeed)
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
        $messageBrokerFacade = $this->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($configureTaxAppMessage);
        $messageBrokerFacade->startWorker(
            $this->buildMessageBrokerWorkerConfigTransfer([$channelName], 1),
        );
        $this->resetInMemoryMessages();
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param string $vendorCode
     *
     * @return \Orm\Zed\TaxApp\Persistence\SpyTaxAppConfig|null
     */
    protected function findTaxAppConfigEntity(StoreTransfer $storeTransfer, string $vendorCode): ?SpyTaxAppConfig
    {
        return (new SpyTaxAppConfigQuery())
            ->filterByFkStore($storeTransfer->getIdStore())
            ->filterByVendorCode($vendorCode)
            ->findOne();
    }
}
