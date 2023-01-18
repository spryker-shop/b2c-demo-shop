<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Touch\Business;

use Codeception\Test\Unit;
use Orm\Zed\Touch\Persistence\SpyTouchQuery;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Touch
 * @group Business
 * @group TouchTest
 * Add your own group annotations below this line
 */
class TouchTest extends Unit
{
    /**
     * @return void
     */
    public function testDatabaseAccessWorks(): void
    {
        $query = SpyTouchQuery::create();
        $query->count();
    }
}
