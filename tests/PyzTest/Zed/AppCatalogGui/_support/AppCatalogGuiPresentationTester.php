<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\AppCatalogGui;

use Codeception\Actor;

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
 * @SuppressWarnings(\PyzTest\Zed\AppCatalogGui\PHPMD)
 *
 * @method \Spryker\Zed\AppCatalogGui\AppCatalogGuiConfig getModuleConfig()
 */
class AppCatalogGuiPresentationTester extends Actor
{
    use _generated\AppCatalogGuiPresentationTesterActions;

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return mb_substr($this->getLocator()->locale()->facade()->getCurrentLocaleName(), 0, 2);
    }
}
