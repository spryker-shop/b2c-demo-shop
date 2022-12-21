<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ExampleProductSalePage\Controller;

use Pyz\Yves\ExampleProductSalePage\Plugin\Router\ExampleProductSaleRouteProviderPlugin;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method \Pyz\Yves\ExampleProductSalePage\ExampleProductSalePageFactory getFactory()
 * @method \Pyz\Client\ExampleProductSalePage\ExampleProductSalePageClientInterface getClient()
 */
class SaleController extends AbstractController
{
    /**
     * @param string $categoryPath
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexPyzAction($categoryPath, Request $request): View
    {
        $parameters = $request->query->all();

        $categoryNode = [];
        if ($categoryPath) {
            $categoryNode = $this->getPyzCategoryNode($categoryPath);

            $parameters['category'] = $categoryNode['node_id'];
        }

        $searchResults = $this
            ->getClient()
            ->salePyzSearch($parameters);

        $searchResults['category'] = $categoryNode;
        $searchResults['filterPath'] = ExampleProductSaleRouteProviderPlugin::PYZ_ROUTE_NAME_SALE;
        $searchResults['viewMode'] = $this->getFactory()
            ->getPyzCatalogClient()
            ->getCatalogViewMode($request);

        return $this->view(
            $searchResults,
            $this->getFactory()->getExampleProductSalePageWidgetPlugins(),
            '@ExampleProductSalePage/views/sale-example/sale-example.twig',
        );
    }

    /**
     * @param string $categoryPath
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return array
     */
    protected function getPyzCategoryNode($categoryPath): array
    {
        $categoryPathPrefix = '/' . $this->getFactory()->getPyzStore()->getCurrentLanguage();
        $fullCategoryPath = $categoryPathPrefix . '/' . ltrim($categoryPath, '/');

        $categoryNode = $this->getFactory()
            ->getPyzUrlStorageClient()
            ->matchUrl($fullCategoryPath, $this->getLocale());

        if (!$categoryNode || empty($categoryNode['data'])) {
            throw new NotFoundHttpException(sprintf(
                'Category not found by path %s (full path %s)',
                $categoryPath,
                $fullCategoryPath,
            ));
        }

        return $categoryNode['data'];
    }
}
