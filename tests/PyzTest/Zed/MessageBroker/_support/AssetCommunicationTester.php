<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PyzTest\Zed\MessageBroker;

use Codeception\Actor;
use Orm\Zed\Asset\Persistence\SpyAsset;
use Orm\Zed\Asset\Persistence\SpyAssetQuery;

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
class AssetCommunicationTester extends Actor
{
    use _generated\AssetCommunicationTesterActions;

    /**
     * @param string $assetUuid
     *
     * @return \Orm\Zed\Asset\Persistence\SpyAsset|null
     */
    public function findAssetByUuid(string $assetUuid): ?SpyAsset
    {
        return (new SpyAssetQuery())
            ->filterByAssetUuid($assetUuid)
            ->findOne();
    }
}
