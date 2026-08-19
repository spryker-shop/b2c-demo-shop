<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Categories\RestApi;

use Generated\Shared\Transfer\CategoryTransfer;
use PyzTest\Glue\Categories\CategoriesRestApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Categories
 * @group RestApi
 * @group CategoriesRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CategoriesRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    protected CategoryTransfer $categoryTransfer;

    public function getCategoryTransfer(): CategoryTransfer
    {
        return $this->categoryTransfer;
    }

    public function buildFixtures(CategoriesRestApiTester $I): FixturesContainerInterface
    {
        $this->createCategory($I);

        return $this;
    }

    protected function createCategory(CategoriesRestApiTester $I): void
    {
        $storeTransfer = $I->getLocator()->store()->facade()->getCurrentStore();

        $this->categoryTransfer = $I->haveLocalizedCategory();

        $I->haveCategoryStoreRelation(
            $this->categoryTransfer->getIdCategory(),
            $storeTransfer->getIdStore(),
        );
    }
}
