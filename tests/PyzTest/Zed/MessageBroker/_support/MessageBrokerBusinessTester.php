<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker;

use Codeception\Actor;
use Spryker\Zed\MessageBroker\Business\MessageBrokerFacadeInterface;

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
 * @SuppressWarnings(\PyzTest\Zed\MessageBroker\PHPMD)
 */
class MessageBrokerBusinessTester extends Actor
{
    use _generated\MessageBrokerBusinessTesterActions;

    /**
     * @return \Spryker\Zed\MessageBroker\Business\MessageBrokerFacadeInterface
     */
    public function getMessageBrokerFacade(): MessageBrokerFacadeInterface
    {
        return $this->getLocator()->messageBroker()->facade();
    }
}
