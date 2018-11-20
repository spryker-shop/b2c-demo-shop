<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductCategoryFilterGui\Communication\Controller;

use Generated\Shared\Search\PageIndexMap;
use Spryker\Client\Search\Plugin\Elasticsearch\ResultFormatter\FacetResultFormatterPlugin;
use Spryker\Zed\ProductCategoryFilterGui\Communication\Controller\ProductCategoryFilterController as SprykerProductCategoryFilterController;
use Spryker\Zed\ProductCategoryFilterGui\Communication\Form\ProductCategoryFilterForm;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\ProductCategoryFilterGui\Communication\ProductCategoryFilterGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductCategoryFilterGui\Persistence\ProductCategoryFilterGuiQueryContainerInterface getQueryContainer()
 */
class ProductCategoryFilterController extends SprykerProductCategoryFilterController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $idCategory = $this->castId($request->query->get(self::PARAM_ID_CATEGORY_NODE));
        $localeTransfer = $this->getCurrentLocale();

        $category = $this->getCategory($idCategory, $localeTransfer->getIdLocale());

        $productCategoryFilterDataProvider = $this->getFactory()
            ->createProductCategoryFilterDataProvider();

        $productCategoryFilterFormatter = $this->getFactory()->createProductCategoryFilterFormatter();

        $productCategoryFilterForm = $this->getFactory()
            ->getProductCategoryFilterForm(
                $productCategoryFilterDataProvider->getData(),
                $productCategoryFilterDataProvider->getOptions()
            )
            ->handleRequest($request);

        $savedProductCategoryFilters = $this->getFactory()
            ->getProductCategoryFilterFacade()
            ->findProductCategoryFilterByCategoryId($idCategory);

        $productCategoryFilterTransfer = $productCategoryFilterFormatter
            ->generateTransferWithJsonFromTransfer($savedProductCategoryFilters);

        $searchResultsForCategory = $this->getFactory()
            ->getCatalogClient()
            ->catalogSearch('', [PageIndexMap::CATEGORY => $idCategory]);

        if ($productCategoryFilterForm->isSubmitted() && $productCategoryFilterForm->isValid()) {
            $productCategoryFilterTransfer = $productCategoryFilterFormatter->generateTransferFromJson(
                $savedProductCategoryFilters->getIdProductCategoryFilter(),
                $idCategory,
                $productCategoryFilterForm->getData()[ProductCategoryFilterForm::FIELD_FILTERS]
            );

            $facadeFunction = 'createProductCategoryFilter';
            if ($productCategoryFilterTransfer->getIdProductCategoryFilter()) {
                $facadeFunction = 'updateProductCategoryFilter';
            }

            $this->getFactory()
                ->getProductCategoryFilterFacade()
                ->$facadeFunction($productCategoryFilterTransfer);

            $this->addSuccessMessage(sprintf('Filters for Category "%s" were updated successfully.', $category->getName()));
        }

        $filters = [];

        if (count($productCategoryFilterTransfer->getFilters()) === 0) {
            $filters = $this->getFactory()
                ->getProductCategoryFilterClient()
                ->updateFacetsByCategory(
                    $searchResultsForCategory[FacetResultFormatterPlugin::NAME],
                    $productCategoryFilterTransfer->getFilterDataArray()
                );
        }

        $nonSearchFilters = $this->getNonSearchFilters(
            ($productCategoryFilterTransfer->getFilters() !== null) ? (array)$productCategoryFilterTransfer->getFilters() : [],
            $searchResultsForCategory[FacetResultFormatterPlugin::NAME]
        );

        return $this->viewResponse([
            'productCategoryFilterForm' => $productCategoryFilterForm->createView(),
            'category' => $category,
            'filters' => $filters,
            'productCategoryFilters' => $productCategoryFilterTransfer,
            'allFilters' => $searchResultsForCategory[FacetResultFormatterPlugin::NAME],
            'nonSearchAttributes' => $nonSearchFilters,
        ]);
    }
}
