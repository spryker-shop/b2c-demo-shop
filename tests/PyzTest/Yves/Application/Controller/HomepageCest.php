<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Application\Controller;

use PyzTest\Yves\Application\ApplicationControllerTester;
use PyzTest\Yves\Application\PageObject\Homepage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Application
 * @group Controller
 * @group HomepageCest
 * Add your own group annotations below this line
 */
class HomepageCest
{
    /**
     * @param \PyzTest\Yves\Application\ApplicationControllerTester $i
     *
     * @return void
     */
    public function testICanOpenHomepage(ApplicationControllerTester $i): void
    {
        $i->wantTo('See that i can open the homepage');
        $i->amOnPage(Homepage::URL);
        $i->canSeeElement('[data-qa="page"]');
    }
}
