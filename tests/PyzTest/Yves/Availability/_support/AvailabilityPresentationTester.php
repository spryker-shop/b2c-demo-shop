<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Availability;

use Codeception\Actor;
use Codeception\Scenario;

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
class AvailabilityPresentationTester extends Actor
{
    use _generated\AvailabilityPresentationTesterActions;

    public const FUJITSU_PRODUCT_ID = 118;
    public const FUJITSU_PRODUCT_PAGE = '/en/fujitsu-esprimo-e420-118';
    public const FUJITSU2_PRODUCT_PAGE = '/en/fujitsu-esprimo-e920-119';
    public const ADD_FUJITSU2_PRODUCT_TO_CART_URL = '/cart/add/119_29804808';

    public const CART_PRE_CHECK_AVAILABILITY_ERROR_MESSAGE = 'Item 119_29804808 only has availability of 10.';

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);

        $this->amYves();
    }

    /**
     * @return void
     */
    public function processCheckout()
    {
        $this->processAllCheckoutSteps();
    }
}
