<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Categories\RestApi;

use PyzTest\Glue\Categories\CategoriesRestApiTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Categories
 * @group RestApi
 * @group CategoriesRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CategoriesRestApiCest
{
    /**
     * @var \PyzTest\Glue\Categories\RestApi\CategoriesRestApiFixtures
     */
    protected CategoriesRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Categories\CategoriesRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CategoriesRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\Categories\RestApi\CategoriesRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(CategoriesRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Categories\CategoriesRestApiTester $I
     *
     * @return void
     */
    public function requestCategoryNodeHasUrlAttribute(CategoriesRestApiTester $I): void
    {
        // Act
        $I->sendGET(
            $I->formatUrl(
                'category-nodes/{CategoryNodeId}',
                [
                    'CategoryNodeId' => $this->fixtures->getCategoryTransfer()->getCategoryNode()->getIdCategoryNode(),
                ],
            ),
        );

        // Assert
        $I->amSure('Returned resource contains `url` attribute')
            ->whenI()
            ->seeSingleResourceHasAttribute('url');
    }
}
