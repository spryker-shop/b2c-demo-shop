<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\ProductReview;

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
 * @SuppressWarnings(\PyzTest\Zed\ProductReview\PHPMD)
 */
class ProductReviewTester extends Actor
{
    use _generated\ProductReviewTesterActions;

    /**
     * @return bool
     */
    public function seeThatDynamicStoreEnabled(): bool
    {
        return $this->getLocator()->store()->facade()->isDynamicStoreEnabled();
    }
}
