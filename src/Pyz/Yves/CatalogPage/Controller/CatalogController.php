<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\CatalogPage\Controller;

use Generated\Shared\Search\PageIndexMap;
use SprykerShop\Yves\CatalogPage\Controller\CatalogController as SprykerCatalogController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\CatalogPage\CatalogPageFactory getFactory()
 * @method \Spryker\Client\Catalog\CatalogClientInterface getClient()
 */
class CatalogController extends SprykerCatalogController
{
    const CATEGORY_BANNER_PATH = '/assets/images/';

    /**
     * @var array
     */
    protected $availableBannerTypes = ['.jpg', '.png'];

    /**
     * @param array $categoryNode
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(array $categoryNode, Request $request)
    {
        $searchString = $request->query->get('q', '');
        $idCategoryNode = $categoryNode['node_id'];
        $idCategory = $categoryNode['id_category'];

        $parameters = $request->query->all();
        $parameters[PageIndexMap::CATEGORY] = $idCategoryNode;

        $searchResults = $this
            ->getFactory()
            ->getCatalogClient()
            ->catalogSearch($searchString, $parameters);

        $searchResults = $this->updateFacetFiltersByCategory($searchResults, $idCategory);
        $metaTitle = isset($categoryNode['meta_title']) ? $categoryNode['meta_title'] : '';
        $metaDescription = isset($categoryNode['meta_description']) ? $categoryNode['meta_description'] : '';
        $metaKeywords = isset($categoryNode['meta_keywords']) ? $categoryNode['meta_keywords'] : '';
        $categoryNode['banner_path'] = $this->getCategoryBannerPath($categoryNode);
        $metaAttributes = [
            'idCategory' => $idCategory,
            'category' => $categoryNode,
            'pageTitle' => ($metaTitle ?: $categoryNode['name']),
            'pageDescription' => $metaDescription,
            'pageKeywords' => $metaKeywords,
            'searchString' => $searchString,
            'viewMode' => $this->getFactory()
                ->getCatalogClient()
                ->getCatalogViewMode($request),
        ];

        $searchResults = array_merge($searchResults, $metaAttributes);
        $template = $this->getCategoryNodeTemplate($idCategoryNode);

        return $this->view(
            $searchResults,
            $this->getFactory()->getCatalogPageWidgetPlugins(),
            $template
        );
    }

    /**
     * @param array $categoryNode
     *
     * @return null|string
     */
    protected function getCategoryBannerPath(array $categoryNode)
    {
        $shotPath = $this->formatBannerName($categoryNode);

        foreach ($this->availableBannerTypes as $type) {
            $filePath = APPLICATION_ROOT_DIR . '/public/Yves' . $shotPath . $type;
            if (file_exists($filePath)) {
                return $shotPath . $type;
            }
        }

        return null;
    }

    /**
     * @param array $categoryNode
     *
     * @return string
     */
    protected function formatBannerName(array $categoryNode)
    {
        $categoryName = str_replace(' ', '-', $categoryNode['name']);
        $categoryName = preg_replace('/[^A-Za-z0-9\-]/', '', $categoryName);
        $categoryName = preg_replace('/-+/', '-', $categoryName);

        return self::CATEGORY_BANNER_PATH . 'category-' . strtolower($categoryName) . '-' . $categoryNode['id_category'];
    }
}
