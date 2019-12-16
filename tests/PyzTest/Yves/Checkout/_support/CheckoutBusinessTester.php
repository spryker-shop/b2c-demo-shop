<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout;

use Codeception\Actor;
use Spryker\Service\Customer\CustomerServiceInterface;
use Spryker\Service\Shipment\ShipmentServiceInterface;

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
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class CheckoutBusinessTester extends Actor
{
    use _generated\CheckoutBusinessTesterActions;

   /**
    * Define custom actions here
    */

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\Customer\CustomerServiceInterface
     */
    public function getCustomerService(): CustomerServiceInterface
    {
        return $this->getLocator()->customer()->service();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Service\Shipment\ShipmentServiceInterface
     */
    public function getShipmentService(): ShipmentServiceInterface
    {
        return $this->getLocator()->shipment()->service();
    }
}
