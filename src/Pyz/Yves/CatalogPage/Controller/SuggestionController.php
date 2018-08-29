<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CatalogPage\Controller;

use SprykerShop\Yves\CatalogPage\Controller\SuggestionController as SprykerShopSuggestionController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\CatalogPage\CatalogPageFactory getFactory()
 */
class SuggestionController extends SprykerShopSuggestionController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction(Request $request)
    {
        $searchString = $request->query->get(self::PARAM_SEARCH_QUERY);

        if (empty($searchString)) {
            return $this->jsonResponse();
        }

        $searchResults = $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSuggestSearch($searchString, $request->query->all());

        return $this->jsonResponse([
            'completion' => ($searchResults['completion'] ? $searchResults['completion'][0] : null),
            'suggestion' => $this->renderView('@CatalogPage/views/suggestion-results/suggestion-results.twig', $searchResults)->getContent(),
        ]);
    }
}
