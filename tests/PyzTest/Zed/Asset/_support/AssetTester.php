<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Asset;

use Codeception\Actor;
use Orm\Zed\Asset\Persistence\SpyAsset;
use Orm\Zed\Asset\Persistence\SpyAssetQuery;

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
 * @SuppressWarnings(\PyzTest\Zed\Asset\PHPMD)
 */
class AssetTester extends Actor
{
    use _generated\AssetTesterActions;

    /**
     * @return bool
     */
    public function seeThatDynamicStoreEnabled(): bool
    {
        return $this->getLocator()->store()->facade()->isDynamicStoreEnabled();
    }

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
