<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\EventDispatcher\Plugin\EventDispatcher;

use Spryker\Client\Session\SessionClient;
use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\EventDispatcher\EventDispatcherInterface;
use Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;

class FsPreviewEnablerEventDispatcherPlugin extends AbstractPlugin implements EventDispatcherPluginInterface
{
    /**
     * @var string
     */
    protected const FIRSTSPIRIT_PREVIEW_MODE = 'fsPreviewMode';

    /**
     * {@inheritDoc}
     * - Allows everyone to see e-spirit content pages.
     *
     * @api
     *
     * @param \Spryker\Shared\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Shared\EventDispatcher\EventDispatcherInterface
     */
    public function extend(
        EventDispatcherInterface $eventDispatcher,
        ContainerInterface $container
    ): EventDispatcherInterface {
        $sessionClient = new SessionClient();

        if (!$sessionClient->has(static::FIRSTSPIRIT_PREVIEW_MODE)) {
            $sessionClient->set(static::FIRSTSPIRIT_PREVIEW_MODE, $this->getConfig()->getPreviewToken());
            $sessionClient->save();
        }

        return $eventDispatcher;
    }
}
