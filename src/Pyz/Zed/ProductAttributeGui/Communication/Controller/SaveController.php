<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductAttributeGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Spryker\Zed\ProductAttributeGui\Communication\Controller\SaveController as SpySaveController;

/**
 * @method \Spryker\Zed\ProductAttributeGui\Communication\ProductAttributeGuiCommunicationFactory getFactory()
 */
class SaveController extends SpySaveController
{

    /**
     * @var string
     */
    public const CARBON_EMISSION_ATTRIBUTE = 'carbon_emission';

    /**
     * @var string
     */
    public const ATTRIBUTE_KEY = 'key';


    /**
     * @var string
     */
    public const ATTRIBUTE_VALUE = 'value';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|array
     */
    public function productAbstractAction(Request $request)
    {
        if (!$this->validateCsrfToken($request)) {
            return $this->createJsonResponse(static::MESSAGE_INVALID_CSRF_TOKEN, false, Response::HTTP_FORBIDDEN);
        }

        $idProductAbstract = $this->castId($request->get(
            static::PARAM_ID_PRODUCT_ABSTRACT,
        ));

        $json = (string)$request->request->get(static::PARAM_JSON);
        $data = json_decode($json, true);
        foreach ($data as $key => $attribute) {
            if ($attribute[static::ATTRIBUTE_KEY] === static::CARBON_EMISSION_ATTRIBUTE) {
                $attribute[static::ATTRIBUTE_VALUE] = "50";
                $data[$key] = $attribute;
            }
        }

        $this->getFactory()
            ->getProductAttributeFacade()
            ->saveAbstractAttributes($idProductAbstract, $data);

        return $this->createJsonResponse(static::MESSAGE_PRODUCT_ABSTRACT_ATTRIBUTES_SAVED);
    }
}
