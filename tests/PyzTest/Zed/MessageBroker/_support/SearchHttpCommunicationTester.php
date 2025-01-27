<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\MessageBroker;

use Codeception\Actor;
use Generated\Shared\DataBuilder\SearchEndpointAvailableBuilder;
use Generated\Shared\DataBuilder\SearchEndpointRemovedBuilder;
use Generated\Shared\Transfer\SearchEndpointAvailableTransfer;
use Generated\Shared\Transfer\SearchEndpointRemovedTransfer;
use Orm\Zed\SearchHttp\Persistence\SpySearchHttpConfig;
use Orm\Zed\SearchHttp\Persistence\SpySearchHttpConfigQuery;
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
 * @SuppressWarnings(\PyzTest\Zed\SearchHttp\PHPMD)
 */
class SearchHttpCommunicationTester extends Actor
{
    use _generated\SearchHttpCommunicationTesterActions;

    /**
     * @return void
     */
    public function assertSearchHttpConfigExistsForStore(): void
    {
        $searchHttpConfigEntity = $this->getSearchHttpConfigEntity();

        $this->assertNotNull($searchHttpConfigEntity);
    }

    /**
     * @return void
     */
    public function assertSearchHttpConfigIsRemoved(): void
    {
        $searchHttpConfigEntity = $this->getSearchHttpConfigEntity();

        $this->assertSame(
            ['search_http_configs' => []],
            $searchHttpConfigEntity->getData(),
        );
    }

    /**
     * @return \Generated\Shared\Transfer\SearchEndpointAvailableTransfer
     */
    public function buildSearchEndpointAvailableTransfer(): SearchEndpointAvailableTransfer
    {
        return (new SearchEndpointAvailableBuilder())
            ->withMessageAttributes()
            ->build();
    }

    /**
     * @return \Generated\Shared\Transfer\SearchEndpointRemovedTransfer
     */
    public function buildSearchEndpointRemovedTransfer(): SearchEndpointRemovedTransfer
    {
        return (new SearchEndpointRemovedBuilder())
            ->withMessageAttributes()
            ->build();
    }

    /**
     * @return void
     */
    public function removeHttpConfig(): void
    {
        (new SpySearchHttpConfigQuery())
            ->deleteAll();
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $searchMessageTransfer
     *
     * @return void
     */
    public function handleSearchMessage(TransferInterface $searchMessageTransfer): void
    {
        $channelName = 'search-commands';
        $this->setupMessageBroker($searchMessageTransfer::class, $channelName);
        $this->setupMessageBrokerPlugins();
        $messageBrokerFacade = $this->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($searchMessageTransfer);
        $messageBrokerFacade->startWorker(
            $this->buildMessageBrokerWorkerConfigTransfer([$channelName], 1),
        );
        $this->resetInMemoryMessages();
    }

    /**
     * @return \Orm\Zed\SearchHttp\Persistence\SpySearchHttpConfig|null
     */
    protected function getSearchHttpConfigEntity(): ?SpySearchHttpConfig
    {
        return (new SpySearchHttpConfigQuery())
            ->findOne();
    }
}
